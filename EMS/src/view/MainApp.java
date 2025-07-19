package view;

import api.AuthService;
import javafx.application.Application;
import javafx.geometry.Insets;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.VBox;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import model.Organizer;
import model.Student;
import org.json.JSONObject;

public class MainApp extends Application {
	@Override
	public void start(Stage stage) {
	    stage.setTitle("EventEase EMS - Login");

	    Label header = new Label("Welcome to EventEase");
	    header.setStyle("-fx-font-size: 20px; -fx-font-weight: bold;");

	    GridPane grid = new GridPane();
	    grid.setPadding(new Insets(20));
	    grid.setHgap(10);
	    grid.setVgap(10);
	    grid.setStyle("-fx-background-color: #f4f8fc; -fx-border-color: #d0d0d0; -fx-border-radius: 8px; -fx-background-radius: 8px;");

	    Label emailLabel = new Label("Email:");
	    TextField emailField = new TextField();
	    Label passLabel = new Label("Password:");
	    PasswordField passField = new PasswordField();
	    Label roleLabel = new Label("Login As:");
	    ComboBox<String> roleCombo = new ComboBox<>();
	    roleCombo.getItems().addAll("student", "organizer");
	    roleCombo.setValue("student");

	    Button loginBtn = new Button("Login");
	    loginBtn.setStyle("-fx-background-color: #4CAF50; -fx-text-fill: white;");
	    Text statusText = new Text();

	    grid.add(emailLabel, 0, 0);
	    grid.add(emailField, 1, 0);
	    grid.add(passLabel, 0, 1);
	    grid.add(passField, 1, 1);
	    grid.add(roleLabel, 0, 2);
	    grid.add(roleCombo, 1, 2);
	    grid.add(loginBtn, 1, 3);
	    grid.add(statusText, 0, 4, 2, 1);

	    // 👇 Section for Register prompt
	    Label noAccountLabel = new Label("Don't have an account?");
	    noAccountLabel.setStyle("-fx-font-size: 13px;");
	    Button registerBtn = new Button("Create Account");
	    registerBtn.setStyle("-fx-background-color: #2196F3; -fx-text-fill: white;");

	    VBox registerBox = new VBox(5, noAccountLabel, registerBtn);
	    registerBox.setPadding(new Insets(20, 0, 0, 0));
	    registerBox.setStyle("-fx-alignment: center;");

	    VBox container = new VBox(20, header, grid, new Separator(), registerBox);
	    container.setPadding(new Insets(30));
	    container.setStyle("-fx-background-color: #eef2f7;");
	    container.setPrefWidth(400);

	    loginBtn.setOnAction(e -> {
	        String email = emailField.getText();
	        String password = passField.getText();
	        String role = roleCombo.getValue();

	        if (email.isEmpty() || password.isEmpty()) {
	            statusText.setText("Please enter both email and password.");
	            return;
	        }

	        try {
	            JSONObject json = AuthService.login(email, password, role);
	            if ("student".equals(role)) {
	                Student student = new Student(json.getInt("student_id"), json.getString("name"), json.getString("email"));
	                stage.setScene(new Scene(new StudentDashboardView(stage, student), 600, 400));
	            } else {
	                Organizer organizer = new Organizer(json.getInt("organizer_id"), json.getString("name"), json.getString("email"));
	                stage.setScene(new Scene(new OrganizerDashboardView(stage, organizer), 800, 500));
	            }
	        } catch (Exception ex) {
	            ex.printStackTrace();
	            statusText.setText("Login failed.");
	        }
	    });

	    registerBtn.setOnAction(e -> showRegisterForm(stage));

	    Scene scene = new Scene(container);
	    stage.setScene(scene);
	    stage.show();
	}

    
    private void showRegisterForm(Stage stage) {
        Label header = new Label("Register New Account");
        header.setStyle("-fx-font-size: 18px; -fx-font-weight: bold;");

        GridPane grid = new GridPane();
        grid.setPadding(new Insets(20));
        grid.setHgap(10);
        grid.setVgap(10);
        grid.setStyle("-fx-background-color: #ffffff; -fx-border-color: #cccccc; -fx-background-radius: 10px; -fx-border-radius: 10px;");

        Label nameLabel = new Label("Name:");
        TextField nameField = new TextField();
        Label emailLabel = new Label("Email:");
        TextField emailField = new TextField();
        Label passLabel = new Label("Password:");
        PasswordField passField = new PasswordField();
        Label roleLabel = new Label("Role:");
        ComboBox<String> roleCombo = new ComboBox<>();
        roleCombo.getItems().addAll("student", "organizer");
        roleCombo.setValue("student");

        Label extra1Label = new Label();
        TextField extra1Field = new TextField();
        Label extra2Label = new Label();
        TextField extra2Field = new TextField();

        roleCombo.setOnAction(e -> {
            if ("student".equals(roleCombo.getValue())) {
                extra1Label.setText("Student Number:");
                extra2Label.setText("Course:");
            } else {
                extra1Label.setText("Organization:");
                extra2Label.setText("Phone:");
            }
        });
        roleCombo.getOnAction().handle(null);

        Button submitBtn = new Button("Register");
        submitBtn.setStyle("-fx-background-color: #4CAF50; -fx-text-fill: white;");
        Button backBtn = new Button("Back");
        backBtn.setStyle("-fx-background-color: #f44336; -fx-text-fill: white;");
        Text statusText = new Text();

        grid.add(nameLabel, 0, 0); grid.add(nameField, 1, 0);
        grid.add(emailLabel, 0, 1); grid.add(emailField, 1, 1);
        grid.add(passLabel, 0, 2); grid.add(passField, 1, 2);
        grid.add(roleLabel, 0, 3); grid.add(roleCombo, 1, 3);
        grid.add(extra1Label, 0, 4); grid.add(extra1Field, 1, 4);
        grid.add(extra2Label, 0, 5); grid.add(extra2Field, 1, 5);
        grid.add(submitBtn, 0, 6);
        grid.add(backBtn, 1, 6);
        grid.add(statusText, 0, 7, 2, 1);

        VBox wrapper = new VBox(15, header, grid);
        wrapper.setPadding(new Insets(30));
        wrapper.setStyle("-fx-background-color: #f9fbfd;");
        wrapper.setPrefWidth(450);

        submitBtn.setOnAction(e -> {
            String name = nameField.getText();
            String email = emailField.getText();
            String password = passField.getText();
            String role = roleCombo.getValue();
            String extra1 = extra1Field.getText();
            String extra2 = extra2Field.getText();

            if (name.isEmpty() || email.isEmpty() || password.isEmpty() || extra1.isEmpty() || extra2.isEmpty()) {
                statusText.setText("Please fill all fields.");
                return;
            }

            try {
                boolean success = AuthService.register(name, email, password, role, extra1, extra2);
                if (success) {
                    statusText.setText("Registration successful! Return to login.");
                } else {
                    statusText.setText("Registration failed.");
                }
            } catch (Exception ex) {
                ex.printStackTrace();
                statusText.setText("Error during registration.");
            }
        });

        backBtn.setOnAction(e -> start(stage));
        stage.setScene(new Scene(wrapper));
    }

    public static void main(String[] args) {
        launch();
    }
}
