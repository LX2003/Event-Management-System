package view;

import model.Organizer;
import api.OrganizerService;
import javafx.beans.property.ReadOnlyStringWrapper;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.*;
import javafx.stage.Stage;
import model.Event;

import java.util.List;

public class OrganizerDashboardView extends VBox {
    private TableView<Event> upcomingTable;
    private TableView<Event> pastTable;
    private ObservableList<Event> upcomingEvents;
    private ObservableList<Event> pastEvents;

    public OrganizerDashboardView(Stage stage, Organizer organizer) {
        setPadding(new Insets(20));
        setSpacing(15);
        setStyle("-fx-background-color: #f5f9ff;");

        Label welcomeLabel = new Label("Welcome, " + organizer.getName());
        welcomeLabel.setStyle("-fx-font-size: 18px; -fx-font-weight: bold;");

        Button logoutBtn = new Button("Logout");
        logoutBtn.setStyle("-fx-background-color: #e53935; -fx-text-fill: white;");

        Region spacer = new Region();
        HBox.setHgrow(spacer, Priority.ALWAYS);

        HBox topBar = new HBox(10, welcomeLabel, spacer, logoutBtn);
        topBar.setSpacing(20);
        topBar.setPadding(new Insets(10, 0, 10, 0));
        topBar.setAlignment(Pos.CENTER);

        Button createBtn = new Button("➕ Create New Event");
        createBtn.setStyle("-fx-background-color: #4CAF50; -fx-text-fill: white;");

        upcomingTable = new TableView<>();
        pastTable = new TableView<>();
        upcomingEvents = FXCollections.observableArrayList();
        pastEvents = FXCollections.observableArrayList();
        upcomingTable.setItems(upcomingEvents);
        pastTable.setItems(pastEvents);

        setupTableColumns(upcomingTable, true);
        setupTableColumns(pastTable, false);

        HBox actionButtons = new HBox(10);
        actionButtons.setPadding(new Insets(10, 0, 10, 0));

        Button updateBtn = new Button("✏️ Edit");
        Button deleteBtn = new Button("🗑️ Delete");
        Button viewFeedbackBtn = new Button("💬 View Feedback");
        Button stopRegBtn = new Button("🚫 Toggle Registration");
        Button exportBtn = new Button("📤 Export Participants");

        styleActionButton(updateBtn, "#1976D2");
        styleActionButton(deleteBtn, "#D32F2F");
        styleActionButton(viewFeedbackBtn, "#455A64");
        styleActionButton(stopRegBtn, "#F57C00");
        styleActionButton(exportBtn, "#388E3C");

        actionButtons.getChildren().addAll(updateBtn, deleteBtn, viewFeedbackBtn, exportBtn, stopRegBtn);

        logoutBtn.setOnAction(e -> {
            try {
                new MainApp().start(stage);
            } catch (Exception ex) {
                ex.printStackTrace();
            }
        });

        createBtn.setOnAction(e -> stage.setScene(new Scene(new CreateEventView(stage, organizer), 500, 450)));

        updateBtn.setOnAction(e -> {
            Event selected = upcomingTable.getSelectionModel().getSelectedItem();
            if (selected != null) {
                stage.setScene(new Scene(new UpdateEventView(stage, organizer, selected), 600, 600));
            } else {
                showError("Please select an event to edit.");
            }
        });

        deleteBtn.setOnAction(e -> {
            Event selected = upcomingTable.getSelectionModel().getSelectedItem();
            if (selected != null) {
                Alert confirm = new Alert(Alert.AlertType.CONFIRMATION, "Delete this event?", ButtonType.YES, ButtonType.NO);
                confirm.showAndWait().ifPresent(response -> {
                    if (response == ButtonType.YES) {
                        if (OrganizerService.deleteEvent(selected.getEvent_id())) {
                            upcomingEvents.remove(selected);
                        } else {
                            showError("Failed to delete event.");
                        }
                    }
                });
            } else {
                showError("Please select an event to delete.");
            }
        });

        viewFeedbackBtn.setOnAction(e -> {
            Event selected = pastTable.getSelectionModel().getSelectedItem();
            if (selected != null) {
                stage.setScene(new Scene(new FeedbackListView(stage, organizer, selected), 500, 400));
            } else {
                showError("Please select a past event to view feedback.");
            }
        });

        exportBtn.setOnAction(e -> {
            Event selected = upcomingTable.getSelectionModel().getSelectedItem();
            if (selected == null) {
                selected = pastTable.getSelectionModel().getSelectedItem();
            }
            if (selected != null) {
                OrganizerService.exportParticipants(selected.getEvent_id());
            } else {
                showError("Please select an event to export participants.");
            }
        });

        stopRegBtn.setOnAction(e -> {
            Event selected = upcomingTable.getSelectionModel().getSelectedItem();
            if (selected != null) {
                boolean newStatus = !selected.isAllowRegistration();
                boolean success = OrganizerService.setEventRegistrationAllowed(selected.getEvent_id(), newStatus);
                if (success) {
                    loadEvents(organizer.getOrganizer_id());
                } else {
                    showError("Failed to update registration status.");
                }
            } else {
                showError("Please select an upcoming event.");
            }
        });

        upcomingTable.getSelectionModel().selectedItemProperty().addListener((obs, oldSel, newSel) -> {
            if (newSel != null) {
                stopRegBtn.setText(newSel.isAllowRegistration() ? "🚫 Close Registration" : "✅ Open Registration");
            } else {
                stopRegBtn.setText("🚫 Toggle Registration");
            }
        });

        pastTable.getSelectionModel().selectedItemProperty().addListener((obs, oldVal, newVal) -> {
            viewFeedbackBtn.setDisable(newVal == null);
        });

        viewFeedbackBtn.setDisable(true);

        loadEvents(organizer.getOrganizer_id());

        Label upcomingLabel = new Label("📅 Upcoming Events");
        upcomingLabel.setStyle("-fx-font-size: 16px; -fx-font-weight: bold;");
        Label pastLabel = new Label("🕘 Past Events");
        pastLabel.setStyle("-fx-font-size: 16px; -fx-font-weight: bold;");

        getChildren().addAll(
            topBar,
            createBtn,
            upcomingLabel,
            upcomingTable,
            actionButtons,
            new Separator(),
            pastLabel,
            pastTable
        );
    }

    private void setupTableColumns(TableView<Event> table, boolean isUpcoming) {
        TableColumn<Event, String> titleCol = new TableColumn<>("Title");
        titleCol.setCellValueFactory(data -> data.getValue().titleProperty());

        TableColumn<Event, String> dateCol = new TableColumn<>("Date/Time");
        dateCol.setCellValueFactory(data -> data.getValue().datetimeProperty());

        TableColumn<Event, String> locCol = new TableColumn<>("Location");
        locCol.setCellValueFactory(data -> data.getValue().locationProperty());

        table.getColumns().clear();
        table.getColumns().addAll(titleCol, dateCol, locCol);

        if (isUpcoming) {
            TableColumn<Event, String> regStatusCol = new TableColumn<>("Registration");
            regStatusCol.setCellValueFactory(data ->
                new ReadOnlyStringWrapper(data.getValue().isAllowRegistration() ? "Open" : "Closed")
            );
            table.getColumns().add(regStatusCol);
        }

        table.setColumnResizePolicy(TableView.CONSTRAINED_RESIZE_POLICY);
        table.setStyle("-fx-border-color: #cfd8dc; -fx-border-radius: 5;");
    }

    private void loadEvents(int organizerId) {
        List<Event> upcoming = OrganizerService.getUpcomingEventsByOrganizer(organizerId);
        List<Event> past = OrganizerService.getPastEventsByOrganizer(organizerId);
        upcomingEvents.setAll(upcoming);
        pastEvents.setAll(past);
    }

    private void showError(String message) {
        Alert alert = new Alert(Alert.AlertType.ERROR);
        alert.setTitle("Error");
        alert.setContentText(message);
        alert.show();
    }

    private void styleActionButton(Button button, String bgColor) {
        button.setStyle(
            "-fx-background-color: " + bgColor + "; -fx-text-fill: white; -fx-font-weight: bold;"
        );
    }
}
