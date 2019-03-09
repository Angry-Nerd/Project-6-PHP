package com.example.project_6;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.support.annotation.RequiresApi;
import android.util.Log;
import android.widget.Toast;

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

import static java.nio.charset.StandardCharsets.*;

public class BackgroudTask extends AsyncTask<String,Void,String> {
    Context ctx;
    String email;
    public BackgroudTask(Context ctx) {
        this.ctx = ctx;
    }
    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected String doInBackground(String... params) {
        String reg_url = "https://esicare.cf/register.php";
        String login_url = "https://esicare.cf/login.php";
        String method = params[0];
        if(method.equals("register")){
            String username = params[1];
            String pwd = params[2];
            try{
                URL url = new URL(reg_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter= new BufferedWriter(new OutputStreamWriter(outputStream, UTF_8));
                String data = URLEncoder.encode("user_name","UTF-8") + "=" + URLEncoder.encode(username,"UTF-8") + "&"+
                        URLEncoder.encode("pwd","UTF-8") + "=" + URLEncoder.encode(pwd,"UTF-8");
                bufferedWriter.write(data);
                bufferedWriter.flush();
                bufferedWriter.close();
                outputStream.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                inputStream.close();
                return "Success";
            } catch(MalformedURLException e){
                Log.e("Malformed",e.getMessage());
            }
            catch (IOException e) {
                Log.e("Malformed",e.getMessage());
            }
        } else if(method.equals("login")){
            String username = params[1];
            String pwd = params[2];
            email = username;
            try{
                URL url = new URL(login_url);
                HttpURLConnection httpURLConnection = (HttpURLConnection) url.openConnection();
                httpURLConnection.setRequestMethod("POST");
                httpURLConnection.setDoOutput(true);
                httpURLConnection.setDoInput(true);
                OutputStream outputStream = httpURLConnection.getOutputStream();
                BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream,"UTF-8"));
                String data = URLEncoder.encode("login_name","UTF-8")+"="+URLEncoder.encode(username,"UTF-8")+"&"+
                        URLEncoder.encode("login_pwd","UTF-8")+"="+URLEncoder.encode(pwd,"UTF-8");
                bufferedWriter.write(data);
                bufferedWriter.flush();
                bufferedWriter.close();
                InputStream inputStream = httpURLConnection.getInputStream();
                BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream,"iso-8859-1"));
                String line;
                StringBuilder stringBuilder = new StringBuilder();
                while((line = bufferedReader.readLine())!=null){
                    stringBuilder.append(line).append("\n");
                }
                bufferedReader.close();
                inputStream.close();
                httpURLConnection.disconnect();
                return stringBuilder.toString();
            } catch (MalformedURLException e) {
                Log.e("Malformed",e.getMessage());
            } catch (IOException e) {
                Log.e("IOException",e.getMessage());
            }
            return null;
        }
        return "Failed";
    }

    @Override
    protected void onPostExecute(String result) {
        if(result.equals("Success")) {
            Toast.makeText(ctx, result, Toast.LENGTH_LONG).show();
        }
        else{
            if(result.equals("Failed\n")){
                Toast.makeText(ctx,"Failed",Toast.LENGTH_LONG).show();
            } else {
                new Prefrences(ctx).writeYesPreference();
                new Prefrences(ctx).setEmail(email);
                Intent intent = new Intent(ctx,User.class);
                intent.putExtra("email",email);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                ctx.startActivity(intent);
                ((Activity)ctx).finish();
            }
        }
    }
}
