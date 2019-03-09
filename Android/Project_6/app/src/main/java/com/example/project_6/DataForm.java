package com.example.project_6;

import android.Manifest;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Build;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.annotation.RequiresApi;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;

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
import java.util.Objects;

import static android.Manifest.permission.ACCESS_COARSE_LOCATION;
import static android.Manifest.permission.ACCESS_FINE_LOCATION;


public class DataForm extends AppCompatActivity  {
    Button submit;
    FusedLocationProviderClient client;
    EditText noofemp,org,manager,contact,email,address,title,desc;
    String cur_loc;
    String main_email = "esicare6@gmail.com";
    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_data_form);
        client = LocationServices.getFusedLocationProviderClient(this);
        cur_loc = getLocation();
        initalize();
    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    private void initalize() {
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        Objects.requireNonNull(getSupportActionBar()).setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        final String emailId = getIntent().getExtras().getString("email");
        submit = findViewById(R.id.submit);
        noofemp = findViewById(R.id.noofemp);
        org = findViewById(R.id.org);
        manager = findViewById(R.id.manager);
        contact = findViewById(R.id.contact);
        email = findViewById(R.id.email);
        address = findViewById(R.id.address);
        title = findViewById(R.id.title);
        desc = findViewById(R.id.desc);
        new BackgroundTask().execute();
        submit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(
                        noofemp.getText().toString().equals("")
                        || org.getText().toString().equals("")
                        || manager.getText().toString().equals("")
                        || contact.getText().toString().equals("")
                        || email.getText().toString().equals("")
                        || address.getText().toString().equals("")
                        || title.getText().toString().equals("")
                        || desc.getText().toString().equals("")
                ) {
                    Toast.makeText(DataForm.this, "Fill all the details First", Toast.LENGTH_LONG).show();
                    return;
                }
//                if(desc.getText().toString().equalsIgnoreCase("Ambulance") ||
//                        desc.getText().toString().equalsIgnoreCase("camp"));
//                else{
//                    Toast.makeText(DataForm.this,"Type must be Ambulance or Camp",Toast.LENGTH_LONG).show();
//                    return;
//                }
                new BackgroundTask2(noofemp.getText().toString(),contact.getText().toString(),
                        address.getText().toString(),org.getText().toString(),
                        manager.getText().toString(),emailId,title.getText().toString(),desc.getText().toString()
                ).execute(main_email);
                finish();
            }
        });

        email.setText(emailId);
    }


//    class BackgroundTask extends AsyncTask<String,Void,String> {
//
//        String loc;
//
//        public BackgroundTask() {
//        }
//
//        @Override
//        protected String doInBackground(String... strings) {
//            String urls = "http://10.0.2.2/SIH_Android/findClosest.php";
//            loc = strings[0];
//            try {
//                URL url = new URL(urls);
//                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
//                httpURLConnection.setRequestMethod("POST");
//                httpURLConnection.setDoInput(true);
//                InputStream inputStream = httpURLConnection.getInputStream();
//                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
//                StringBuilder stringBuilder = new StringBuilder();
//                String Json = "";
//                while ((Json = bufferedReader.readLine()) != null) {
//                    stringBuilder.append(Json);
//                }
//                bufferedReader.close();
//                inputStream.close();
//                httpURLConnection.disconnect();
//                return stringBuilder.toString();
//
//            } catch (Exception e) {
//                Log.e("exception", e.getMessage());
//            }
//
//            return null;
//        }
//
//        @Override
//        protected void onPostExecute(String res) {
//            String jsonString = "{\"users\":" + res + "}";
//            Toast.makeText(DataForm.this, jsonString, Toast.LENGTH_LONG).show();
//            JSONObject jsonObject;
//            JSONArray jsonArray;
//            Location myLocation = new Location(LocationManager.GPS_PROVIDER);
//            myLocation.setLatitude(30.3);
//            myLocation.setLongitude(76.3);
//            try {
//                jsonObject = new JSONObject(jsonString);
//                jsonArray = jsonObject.getJSONArray("users");
//                int count = 0;
//                float min = Integer.MAX_VALUE;
//                String userEmail = "";
//                while (count < jsonArray.length()) {
//                    JSONObject jsonObject1 = jsonArray.getJSONObject(count);
//                    String email = jsonObject1.getString("email");
//                    String address = jsonObject1.getString("address");
//                    String addressArr[] = address.split(",");
//                    Location location = new Location(LocationManager.GPS_PROVIDER);
//                    try {
//                        location.setLatitude(Double.valueOf(addressArr[1]));
//                        location.setLongitude(Double.valueOf(addressArr[2]));
//                        float dist = location.distanceTo(myLocation);
//                        if (dist < min) {
//                            userEmail = email;
//                            min = dist;
//                        }
//                    } catch(Exception e){
//                        e.printStackTrace();
//                    }
//                    count++;
//
//                }
//                new BackgroundTask2(noofemp.getText().toString(),contact.getText().toString(),
//                        address.getText().toString(),org.getText().toString(),manager.getText().toString(),"",title.getText().toString()
//
//                ,"").execute(loc, userEmail);
//            } catch (JSONException e) {
//                Toast.makeText(DataForm.this, e.getMessage(), Toast.LENGTH_LONG).show();
//            }
//
//        }
//    }
    class BackgroundTask2 extends AsyncTask<String,Void,String>{
            String address,contact,noe,org,manager,email,title,type;
            public BackgroundTask2(String noe, String contact, String address,String org
                ,String manager,String email,String title,String type
            ) {
                this.address = address;
                this.noe = noe;
                this.contact = contact;
                this.email = email;
                this.org = org;
                this.manager = manager;
                this.title = title;
                this.type = type;
            }
            @Override
            protected String doInBackground(String... strings) {
                String urls = "https://esicare.cf/registerEvent.php";
                String id = strings[0];
                try{
                    URL url = new URL(urls);
                    HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                    httpURLConnection.setRequestMethod("POST");
                    httpURLConnection.setDoOutput(true);
                    OutputStream outputStream = httpURLConnection.getOutputStream();
                    BufferedWriter bufferedWriter= new BufferedWriter(new OutputStreamWriter(outputStream,"UTF-8"));
                    String data = URLEncoder.encode("email","UTF-8") + "=" + URLEncoder.encode(id,"UTF-8")+"&"+
                            URLEncoder.encode("noe","UTF-8") + "=" + URLEncoder.encode(noe,"UTF-8")+"&"+
                            URLEncoder.encode("contact","UTF-8") + "=" + URLEncoder.encode(contact,"UTF-8")+"&"+
                            URLEncoder.encode("address","UTF-8") + "=" + URLEncoder.encode(address,"UTF-8")+"&"+
                            URLEncoder.encode("manager","UTF-8") + "=" + URLEncoder.encode(manager,"UTF-8")+"&"+
                            URLEncoder.encode("org","UTF-8") + "=" + URLEncoder.encode(org,"UTF-8")+"&"+
                            URLEncoder.encode("title","UTF-8") + "=" + URLEncoder.encode(title,"UTF-8")+"&"+
                            URLEncoder.encode("description","UTF-8") + "=" + URLEncoder.encode(type,"UTF-8");
                    bufferedWriter.write(data);
                    bufferedWriter.flush();
                    bufferedWriter.close();
                    outputStream.close();
                    InputStream inputStream = httpURLConnection.getInputStream();
                    inputStream.close();
                    return "Success";
                } catch(Exception e){
                    Log.e("exception",e.getMessage());
                }
                return null;
            }
            @Override
            protected void onPostExecute(String s) {
                if(s.equals("Success")){
                    Toast.makeText(DataForm.this,"Sent",Toast.LENGTH_LONG).show();
                } else Toast.makeText(DataForm.this,"Failed",Toast.LENGTH_LONG).show();
            }
        }
    class BackgroundTask3 extends AsyncTask<String,Void,String>{
        String jsonString;
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
                String data = URLEncoder.encode("email","UTF-8") + "=" + URLEncoder.encode(voids[0],"UTF-8");
                bufferedWriter.write(data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                StringBuilder stringBuilder = new StringBuilder();
                String Json = "";
                while((Json=bufferedReader.readLine())!=null){
                    stringBuilder.append(Json).append("\n");
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
                String managerT,contactT,orgT,addressT,noeT,typeT;
                JSONObject jsonObject1 = jsonArray.getJSONObject(0);
                orgT = jsonObject1.getString("organisation");
                contactT = jsonObject1.getString("contactnumber");
                addressT = jsonObject1.getString("address");
                managerT = jsonObject1.getString("chairperson");
                noeT = jsonObject1.getString("noofemployees");
                org.setText(orgT);
                manager.setText(managerT);
                contact.setText(contactT);
                address.setText(addressT);
                noofemp.setText(noeT);
            }catch(JSONException e){
                Toast.makeText(DataForm.this,e.getMessage(),Toast.LENGTH_LONG).show();
            }

        }
    }
    class BackgroundTask extends AsyncTask<String,Void,String> {
//        String[] latlongs = cur_loc.split(",");
        @RequiresApi(api = Build.VERSION_CODES.KITKAT)
        @Override
        protected String doInBackground(String... voids) {
            String urls = "https://esicare.cf/fetchUsers.php";
            try {
                URL url = new URL(urls);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoInput(true);
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream));
                StringBuilder stringBuilder = new StringBuilder();
                String Json = "";
                while ((Json = bufferedReader.readLine()) != null) {
                    stringBuilder.append(Json).append("\n");
                }
                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();
                return stringBuilder.toString();
            } catch (MalformedURLException e) {
                Log.e("Malformed", e.getMessage());
            } catch (IOException e) {
                Log.e("Malformed", e.getMessage());
            }
            return null;
        }
        @Override
        protected void onPostExecute(String res) {
            String jsonString = "{\"users\":" + res + "}";
            JSONObject jsonObject;
            JSONArray jsonArray;
            try {
                jsonObject = new JSONObject(jsonString);
                jsonArray = jsonObject.getJSONArray("users");
                JSONObject jsonObject1 = jsonArray.getJSONObject(0);
//                Toast.makeText(DataForm.this,jsonObject1.toString(),Toast.LENGTH_LONG).show();
                noofemp.setText(jsonObject1.getString("noofemployees"));
                org.setText(jsonObject1.getString("organisation"));
                manager.setText(jsonObject1.getString("chairperson"));
                contact.setText(jsonObject1.getString("contactnumber"));
                address.setText(jsonObject1.getString("address"));

            } catch (JSONException e) {
//                Toast.makeText(DataForm.this, e.getMessage(), Toast.LENGTH_LONG).show();
            }

        }

//        private float getLocationDist(String lat, String longi) {
//            if(!flag){
//                return -1;
//            }
//            double l1,l2,l3,l4;
//            l1 = Double.valueOf(lat);
//            l2 = Double.valueOf(longi);
//            l3 = Double.valueOf(latlongs[0]);
//            l4 = Double.valueOf(latlongs[1]);
//            Location location = new Location(LocationManager.GPS_PROVIDER);
//            location.setLatitude(l3);
//            location.setLongitude(l4);
//            Location location1 = new Location(LocationManager.GPS_PROVIDER);;
//            location1.setLatitude(l1);
//            location1.setLongitude(l2);
//            return location.distanceTo(location1);
//        }
//        private String getLocation() {
//            if ((ActivityCompat.checkSelfPermission(List.this, ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) &&
//                    (ActivityCompat.checkSelfPermission(List.this, ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED)){
//                requestPermission();
//                return "loc";
//
//            }
//            final String[] res = new String[1];
//            client.getLastLocation().addOnSuccessListener(new OnSuccessListener<Location>() {
//                @Override
//                public void onSuccess(Location location) {
//                    if(location!=null){
//                        res[0] = location.getLatitude() +","+location.getLongitude();
//                    }
//                }
//            }).addOnFailureListener(new OnFailureListener() {
//                @Override
//                public void onFailure(@NonNull Exception e) {
//                    Toast.makeText(List.this,"Failed",Toast.LENGTH_LONG).show();
//                }
//            });
//            return res[0];
//        }
//        private void requestPermission(){
//            ActivityCompat.requestPermissions(List.this,new String[]{ACCESS_FINE_LOCATION},1);
//        }
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if(item.getItemId()==android.R.id.home){
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
    private String getLocation() {
        if ((ActivityCompat.checkSelfPermission(DataForm.this, ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) &&
                (ActivityCompat.checkSelfPermission(DataForm.this, ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED)){
            requestPermission();
            return "loc";
        }
        final String[] res = new String[1];
        res[0] = "ak";
        client.getLastLocation().addOnSuccessListener(new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                if(location!=null){
                    res[0] = location.getLatitude() +","+location.getLongitude();
                }
            }
        }).addOnFailureListener(new OnFailureListener() {
            @Override
            public void onFailure(@NonNull Exception e) {
                Toast.makeText(DataForm.this,"Failed to retrieve Location",Toast.LENGTH_LONG).show();
            }
        });
        return res[0];
    }
    private void requestPermission(){
        ActivityCompat.requestPermissions(DataForm.this,new String[]{ACCESS_FINE_LOCATION},1);
    }
}
//                    String addresss = jsonObject1.getString("address");
//                    String[] latlong = addresss.split(",");
//                    float dist = getLocationDist(latlong[1],latlong[2]);
//                    if(dist<0){
//                        Toast.makeText(List.this,"Your Address do not contain address",Toast.LENGTH_LONG).show();
//                        break;
//                    }
//                    if(dist<min){
//                        min = dist;
//                        main_email = jsonObject1.getString("email");
//                    }