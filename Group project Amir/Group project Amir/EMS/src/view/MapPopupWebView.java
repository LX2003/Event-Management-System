/*package view;

import javafx.application.Platform;
import javafx.scene.Scene;
import javafx.scene.web.WebEngine;
import javafx.scene.web.WebView;
import javafx.stage.Stage;
import netscape.javascript.JSObject;
import utils.ReverseGeocoder;

public class MapPopupWebView {
    public static void show(java.util.function.Consumer<String> addressCallback) {
        WebView webView = new WebView();
        WebEngine engine = webView.getEngine();

        engine.load(MapPopupWebView.class.getResource("/map.html").toExternalForm());

        engine.documentProperty().addListener((obs, oldDoc, newDoc) -> {
            if (newDoc != null) {
                JSObject window = (JSObject) engine.executeScript("window");
                window.setMember("java", new Object() {
                    public void onLocationSelected(double lat, double lon) {
                        String address = ReverseGeocoder.getAddress(lat, lon);
                        Platform.runLater(() -> addressCallback.accept(address));
                    }
                });
            }
        });

        Stage stage = new Stage();
        stage.setTitle("Pick Location");
        stage.setScene(new Scene(webView, 640, 480));
        stage.show();
    }
}
*/