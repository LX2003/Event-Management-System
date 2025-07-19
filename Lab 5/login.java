import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JTextField;

import org.json.JSONObject;
import org.json.JSONTokener;

import javax.swing.JLabel;
import java.awt.Font;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.JButton;

public class login {

	private JFrame frame;
	private JTextField textField1;
	private JTextField textField2;
	private JTextField textField3;
	private JTextField textField4;
	private JTextField textField5;

	/**
	 * Launch the application.
	 */
	public static void main(String[] args) {
		EventQueue.invokeLater(new Runnable() {
			public void run() {
				try {
					login window = new login();
					window.frame.setVisible(true);
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		});
	}

	/**
	 * Create the application.
	 */
	public login() {
		initialize();
	}
	
	private void searchLogin() {
		String inputLogin = textField1.getText().trim();

		if (inputLogin.isEmpty()) {
			System.out.println("Login field is empty.");
			return;
		}

		try {
			FileReader reader = new FileReader("C:\\School\\Y2S2\\DAD\\Lab5\\DataJson.json");
			JSONTokener tokener = new JSONTokener(reader);
			JSONObject root = new JSONObject(tokener);

			org.json.JSONArray usersArray = root.getJSONArray("arrUsers");

			boolean found = false;

			for (int i = 0; i < usersArray.length(); i++) {
				JSONObject user = usersArray.getJSONObject(i);
				if (user.getString("login").equalsIgnoreCase(inputLogin)) {
					textField2.setText(user.getString("firstname"));
					textField3.setText(user.getString("lastname"));
					textField4.setText(user.getString("type"));
					textField5.setText(user.getString("language"));
					found = true;
					break;
				}
			}

			if (!found) {
				System.out.println("User not found.");
				textField2.setText("");
				textField3.setText("");
				textField4.setText("");
				textField5.setText("");
			}

			reader.close();

		} catch (IOException e) {
			e.printStackTrace();
		} catch (Exception e) {
			System.out.println("Error parsing JSON: " + e.getMessage());
		}
	}



	/**
	 * Initialize the contents of the frame.
	 */
	private void initialize() {
		frame = new JFrame();
		frame.setBounds(100, 100, 450, 300);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.getContentPane().setLayout(null);
		
		textField1 = new JTextField();
		textField1.setBounds(121, 33, 96, 19);
		frame.getContentPane().add(textField1);
		textField1.setColumns(10);
		
		textField2 = new JTextField();
		textField2.setColumns(10);
		textField2.setBounds(78, 81, 96, 19);
		frame.getContentPane().add(textField2);
		
		textField3 = new JTextField();
		textField3.setColumns(10);
		textField3.setBounds(78, 110, 96, 19);
		frame.getContentPane().add(textField3);
		
		textField4 = new JTextField();
		textField4.setColumns(10);
		textField4.setBounds(78, 139, 96, 19);
		frame.getContentPane().add(textField4);
		
		textField5 = new JTextField();
		textField5.setColumns(10);
		textField5.setBounds(78, 168, 96, 19);
		frame.getContentPane().add(textField5);
		
		JLabel lblNewLabel = new JLabel("Login:");
		lblNewLabel.setFont(new Font("Tahoma", Font.BOLD, 12));
		lblNewLabel.setBounds(68, 36, 45, 13);
		frame.getContentPane().add(lblNewLabel);
		
		JLabel lblPassword = new JLabel("Firstname");
		lblPassword.setFont(new Font("Tahoma", Font.BOLD, 12));
		lblPassword.setBounds(10, 83, 68, 13);
		frame.getContentPane().add(lblPassword);
		
		JLabel lblLastName = new JLabel("Last Name");
		lblLastName.setFont(new Font("Tahoma", Font.BOLD, 12));
		lblLastName.setBounds(10, 112, 68, 13);
		frame.getContentPane().add(lblLastName);
		
		JLabel lblType = new JLabel("Type");
		lblType.setFont(new Font("Tahoma", Font.BOLD, 12));
		lblType.setBounds(10, 142, 68, 13);
		frame.getContentPane().add(lblType);
		
		JLabel lblLanguage = new JLabel("Language");
		lblLanguage.setFont(new Font("Tahoma", Font.BOLD, 12));
		lblLanguage.setBounds(10, 171, 68, 13);
		frame.getContentPane().add(lblLanguage);
		
		JButton btnNewButton = new JButton("Search");
		btnNewButton.setFont(new Font("Tahoma", Font.BOLD, 12));
		btnNewButton.setBounds(233, 32, 85, 21);
		btnNewButton.addActionListener(e -> searchLogin());
		frame.getContentPane().add(btnNewButton);
	}
}
