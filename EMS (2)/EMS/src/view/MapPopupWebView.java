package view;

import javafx.application.Platform;
import javafx.scene.Scene;
import javafx.scene.web.WebEngine;
import javafx.scene.web.WebView;
import javafx.stage.Stage;
import netscape.javascript.JSObject;

public class MapPopupWebView {
    public static void show(String address) {
        WebView webView = new WebView();
        WebEngine engine = webView.getEngine();

        // This will be called by JS after map is initialized
        class JavaBridge {
            public void mapReady() {
                Platform.runLater(() -> {
                    engine.executeScript("setLocation('" + address.replace("'", "\\'") + "')");
                });
            }

            // Optional: handle callback with coordinates
            public void locationInfo(double lat, double lng, String formatted) {
                System.out.println("Map resolved: " + formatted + " at (" + lat + ", " + lng + ")");
            }
        }

        engine.documentProperty().addListener((obs, oldDoc, newDoc) -> {
            if (newDoc != null) {
                JSObject window = (JSObject) engine.executeScript("window");
                window.setMember("java", new JavaBridge());
            }
        });

        // Load the HTML file
        engine.load(MapPopupWebView.class.getResource("/map.html").toExternalForm());

        Stage stage = new Stage();
        stage.setTitle("Location Viewer");
        stage.setScene(new Scene(webView, 640, 480));
        stage.show();
    }
}
