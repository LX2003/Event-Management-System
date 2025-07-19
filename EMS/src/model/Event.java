package model;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;
import javafx.beans.property.BooleanProperty;
import javafx.beans.property.SimpleBooleanProperty;

public class Event {
    private int event_id;
    private SimpleStringProperty title;
    private SimpleStringProperty description;
    private SimpleStringProperty datetime;
    private SimpleStringProperty location;
    private final StringProperty organizerName = new SimpleStringProperty();
    private final SimpleStringProperty status = new SimpleStringProperty("Not Registered");
    private int registeredCount;
    private BooleanProperty allowRegistration = new SimpleBooleanProperty(true);//check if registration allowed
    
    private int capacity;

    public Event(int event_id, String title, String description, String datetime, String location, int capacity) {
        this.event_id = event_id;
        this.title = new SimpleStringProperty(title);
        this.description = new SimpleStringProperty(description);
        this.datetime = new SimpleStringProperty(datetime);
        this.location = new SimpleStringProperty(location);
        this.capacity = capacity;
    }

    public int getEvent_id() {
        return event_id;
    }

    public String getTitle() {
        return title.get();
    }

    public String getDescription() {
        return description.get();
    }

    public String getDatetime() {
        return datetime.get();
    }

    public String getLocation() {
        return location.get();
    }

    public int getCapacity() {
        return capacity;
    }

    public SimpleStringProperty titleProperty() {
        return title;
    }

    public SimpleStringProperty descriptionProperty() {
        return description;
    }

    public SimpleStringProperty datetimeProperty() {
        return datetime;
    }

    public SimpleStringProperty locationProperty() {
        return location;
    }

    public StringProperty statusProperty() {
        return status;
    }

    public String getStatus() {
        return status.get();
    }

    public void setStatus(String status) {
        this.status.set(status);
    }
    
    public boolean isRegistered() {
        return "Registered".equalsIgnoreCase(getStatus());
    }
    public String getOrganizerName() {
        return organizerName.get();
    }

    public void setOrganizerName(String name) {
        this.organizerName.set(name);
    }

    public StringProperty organizerNameProperty() {
        return organizerName;
    }
    public boolean isAllowRegistration() { 
    	return allowRegistration.get();
    }
    public void setAllowRegistration(boolean val) {
    	this.allowRegistration.set(val); 
    }
    public BooleanProperty allowRegistrationProperty() { 
    	return allowRegistration; 
    }
    public int getRegisteredCount() {
        return registeredCount;
    }

    public void setRegisteredCount(int registeredCount) {
        this.registeredCount = registeredCount;
    }

    public int getAvailableSlots() {
        return capacity - registeredCount;
    }
} 
