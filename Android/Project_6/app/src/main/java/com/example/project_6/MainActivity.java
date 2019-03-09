package com.example.project_6;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;

public class MainActivity extends AppCompatActivity {

    private EditText inputEmail, inputPassword;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Prefrences prefrences = new Prefrences(this);
        if(prefrences.checkPreference()){
            Intent intent = new Intent(this,User.class);
            intent.putExtra("email",prefrences.getEmail());
            startActivity(intent);
            finish();
        }
        ProgressBar progressBar = findViewById(R.id.progressBar);
        inputEmail =  findViewById(R.id.email);
        inputPassword =  findViewById(R.id.password);
        Button btnSignup = findViewById(R.id.btn_signup);
        Button btnLogin = findViewById(R.id.btn_login);
//        Button btnReset = findViewById(R.id.btn_reset_password);
        progressBar.setVisibility(View.INVISIBLE);
        btnSignup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                inputEmail.setText("");
                inputPassword.setText("");
                startActivity(new Intent(MainActivity.this,Register.class));
            }
        });
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                BackgroudTask backgroudTask = new BackgroudTask(MainActivity.this);
                backgroudTask.execute("login",inputEmail.getText().toString(),inputPassword.getText().toString());
            }
        });

    }
}
