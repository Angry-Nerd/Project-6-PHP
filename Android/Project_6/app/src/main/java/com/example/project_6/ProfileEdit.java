package com.example.project_6;

import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.support.annotation.RequiresApi;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

public class ProfileEdit extends AppCompatActivity {

    EditText address,name,number,managaer,organisation,noe;
    TextView email;
    Button update;
    String email_id;
    String jsonString;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile_edit);
        initalize();
        new ProfileEdit.BackgroundTask().execute();
    }
    private void initalize() {
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        email_id = getIntent().getExtras().getString("email");
        address = findViewById(R.id.profileAddressEdit);
        name = findViewById(R.id.profileNameEdit);
        number = findViewById(R.id.profileNumberEdit);
        email = findViewById(R.id.profileEmailEdit);
        managaer = findViewById(R.id.profileManagerEdit);
        organisation = findViewById(R.id.profileOrganisationEdit);
        noe = findViewById(R.id.profileNOEEdit);
        email.setText(email_id);
        update = findViewById(R.id.update);
        update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new ProfileEdit.BackgroundTask2(name.getText().toString(),address.getText().toString(),number.getText().toString()
                        ,managaer.getText().toString(),organisation.getText().toString(),noe.getText().toString()).execute(email_id);
            }
        });
    }
    class BackgroundTask2 extends AsyncTask<String,Void,String> {
        String name,address,number,org,manager,noes;

        public BackgroundTask2(String name, String address, String number,String manager,String org,String noes) {
            this.name = name;
            this.address = address;
            this.number = number;
            this.org = org;
            this.manager = manager;
            this.noes = noes;
        }

        @Override
        protected String doInBackground(String... strings) {
            String urls = "https://esicare.cf/update.php";
            try {
                URL url = new URL(urls);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);

                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));
                String data = URLEncoder.encode("email", "UTF-8") + "=" + URLEncoder.encode(strings[0], "UTF-8")+"&"+
                        URLEncoder.encode("name", "UTF-8") + "=" + URLEncoder.encode(name, "UTF-8")+"&"+
                        URLEncoder.encode("number", "UTF-8") + "=" + URLEncoder.encode(number, "UTF-8")+"&"+
                        URLEncoder.encode("address", "UTF-8") + "=" + URLEncoder.encode(address, "UTF-8")+"&"+
                        URLEncoder.encode("chairperson", "UTF-8") + "=" + URLEncoder.encode(manager, "UTF-8")+"&"+
                        URLEncoder.encode("organisation", "UTF-8") + "=" + URLEncoder.encode(org, "UTF-8")+"&"+
                        URLEncoder.encode("noe", "UTF-8") + "=" + URLEncoder.encode(noes, "UTF-8");
                bufferedWriter.write(data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                inputStream.close();
                return "Success";
            } catch (Exception e) {
            }
            return "Failed";
        }
        @Override
        protected void onPostExecute(String s) {
            Toast.makeText(ProfileEdit.this,s,Toast.LENGTH_LONG).show();
            ProfileEdit.this.finish();
            Intent i = new Intent(ProfileEdit.this,Profile.class);
            i.putExtra("email",email_id);
            startActivity(i);
        }
    }
    class BackgroundTask extends AsyncTask<String,Void,String>{
        @Override
        protected void onPreExecute() {

        }

        @RequiresApi(api = Build.VERSION_CODES.KITKAT)
        @Override
        protected String doInBackground(String... voids) {
            String urls = "https://esicare.cf/fetch.php";
            try{
                URL url = new URL(urls);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter= new BufferedWriter(new OutputStreamWriter(outputStream,"UTF-8"));
                String data = URLEncoder.encode("email","UTF-8") + "=" + URLEncoder.encode(email_id,"UTF-8");
                bufferedWriter.write(data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                StringBuilder stringBuilder = new StringBuilder();
                String Json = "";
                while((Json=bufferedReader.readLine())!=null){
                    stringBuilder.append(Json);
                }
                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();
                return stringBuilder.toString();
            } catch(MalformedURLException e){
                Log.e("Malformed",e.getMessage());
            }
            catch (IOException e) {
                Log.e("Malformed",e.getMessage());
            }

            return null;
        }

        @Override
        protected void onPostExecute(String res) {
            jsonString = "{\"users\":"+res+"}";
            JSONObject jsonObject;
            JSONArray jsonArray;
            try{
                jsonObject = new JSONObject(jsonString);
                jsonArray = jsonObject.getJSONArray("users");
                String managerT,contactT,nameT,addressT,org,noemployees;
                JSONObject jsonObject1 = jsonArray.getJSONObject(0);
                org = jsonObject1.getString("organisation");
                nameT = jsonObject1.getString("Name");
                noemployees = jsonObject1.getString("noofemployees");
                managerT = jsonObject1.getString("chairperson");
                contactT = jsonObject1.getString("contactnumber");
                addressT = jsonObject1.getString("address");
                name.setText(nameT);
                noe.setText(noemployees);
                managaer.setText(managerT);
                organisation.setText(org);
                number.setText(contactT);
                address.setText(addressT);
            } catch(JSONException e){
                Toast.makeText(ProfileEdit.this,e.getMessage(),Toast.LENGTH_LONG).show();
            }
        }
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(item.getItemId()==android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}
