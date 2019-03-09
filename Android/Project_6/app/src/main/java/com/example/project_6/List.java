package com.example.project_6;

import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Build;
import android.support.annotation.NonNull;
import android.support.annotation.RequiresApi;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.DividerItemDecoration;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.Toast;

import com.google.android.gms.location.FusedLocationProviderClient;
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
import java.util.ArrayList;

import static android.Manifest.permission.ACCESS_COARSE_LOCATION;
import static android.Manifest.permission.ACCESS_FINE_LOCATION;

public class List extends AppCompatActivity {

    private FusedLocationProviderClient client;
    RecyclerView recyclerView;
    ArrayList<String> names,contacts,addresses,distance,emails,type,speciality;
    String id;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_list);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        client = LocationServices.getFusedLocationProviderClient(this);
        new List.BackgroundTask().execute();
        id = getIntent().getExtras().getString("email");
        names = new ArrayList<>();
        addresses = new ArrayList<>();
        contacts = new ArrayList<>();
        distance = new ArrayList<>();
        emails = new ArrayList<>();
        type = new ArrayList<>();
        speciality = new ArrayList<>();
        recyclerView = findViewById(R.id.recycler_view);
        recyclerView.setHasFixedSize(true);
    }
    class BackgroundTask extends AsyncTask<String,Void,String> {
//        String curLoc = getLocation();
//        String[] latlongs = curLoc.split(",");
        boolean flag = false;
        @Override
        protected void onPreExecute() {
//            if(latlongs[0].contains(",")){
//                flag = true;
//            }
        }

        @RequiresApi(api = Build.VERSION_CODES.KITKAT)
        @Override
        protected String doInBackground(String... voids) {
            String urls = "https://esicare.cf/fetchUsers2.php";
            try{
                URL url = new URL(urls);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
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
            String jsonString = "{\"users\":"+res+"}";
            JSONObject jsonObject;
            JSONArray jsonArray;
            try{
                jsonObject = new JSONObject(jsonString);
                jsonArray = jsonObject.getJSONArray("users");
                int c = 0;
                while(c<jsonArray.length()) {
                    JSONObject jsonObject1 = jsonArray.getJSONObject(c);
                    names.add(jsonObject1.getString("name"));
                    String address = jsonObject1.getString("address");
//                    String[] latlong = address.split(",");
//                    float dist = getLocationDist(latlong[1],latlong[2]);
//                    if(dist<0){
//                        Toast.makeText(List.this,"Wrong Address Found for "+jsonObject1.getString("contact"),Toast.LENGTH_LONG).show();
//                        break;
//                    }
                    speciality.add(jsonObject1.getString("facilities"));
                    type.add(jsonObject1.getString("type"));
                    distance.add(10+c+" km");
                    contacts.add(jsonObject1.getString("contact"));
                    addresses.add(address);
                    emails.add(jsonObject1.getString("email"));
                    c++;
                }
                recyclerView.setLayoutManager(new LinearLayoutManager(List.this));
                recyclerView.setAdapter(new MyAdapter(List.this,names,addresses,contacts,distance,emails,type,speciality));
            }catch(JSONException e){
                Toast.makeText(List.this,e.getMessage(),Toast.LENGTH_LONG).show();
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
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        switch(requestCode){
            case 1:
                if(grantResults.length>0 && grantResults[0] == PackageManager.PERMISSION_GRANTED){

                } else {
                    Toast.makeText(this,"Please Grant Permssion first",Toast.LENGTH_LONG).show();
                    finish();
                }
                break;
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
