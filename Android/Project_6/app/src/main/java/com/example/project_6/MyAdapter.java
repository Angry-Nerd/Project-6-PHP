package com.example.project_6;

import android.content.Context;
import android.support.annotation.NonNull;
import android.support.constraint.ConstraintLayout;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.ArrayList;

public class MyAdapter extends RecyclerView.Adapter<MyAdapter.ViewHolder> {

    private ArrayList<String> names;
    private ArrayList<String> address;
    private ArrayList<String> contact;
    private ArrayList<String> distance;
    private ArrayList<String> emails;
    private ArrayList<String> type;
    private ArrayList<String> speciality;
    private Context mContext;

    MyAdapter(Context mContext, ArrayList<String> names, ArrayList<String> address, ArrayList<String> contact, ArrayList<String> distance, ArrayList<String> emails,ArrayList<String> type,ArrayList<String> speciality) {
        this.names = names;
        this.address = address;
        this.contact = contact;
        this.distance = distance;
        this.emails = emails;
        this.type = type;
        this.speciality = speciality;
        this.mContext = mContext;
    }
    @NonNull
    @Override
    public MyAdapter.ViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {
        return new ViewHolder(LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.list_item,viewGroup,false));
    }

    @Override
    public void onBindViewHolder(@NonNull MyAdapter.ViewHolder viewHolder, int i) {
        viewHolder.namesT.setText(names.get(i));
        viewHolder.addressT.setText(address.get(i));
        viewHolder.contactT.setText(contact.get(i));
        viewHolder.distanceT.setText(distance.get(i));
        viewHolder.emailT.setText(emails.get(i));
        viewHolder.typeT.setText(type.get(i));
        viewHolder.speciality.setText(speciality.get(i));
    }

    @Override
    public int getItemCount() {
        return names.size();
    }
    class ViewHolder extends RecyclerView.ViewHolder {
        TextView namesT,addressT,distanceT,contactT,emailT,typeT,speciality;
        ConstraintLayout layout;
        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            namesT = itemView.findViewById(R.id.name);
            addressT = itemView.findViewById(R.id.address);
            contactT = itemView.findViewById(R.id.contact);
            distanceT = itemView.findViewById(R.id.distance);
            layout = itemView.findViewById(R.id.layout);
            emailT = itemView.findViewById(R.id.email);
            typeT = itemView.findViewById(R.id.type);
            speciality = itemView.findViewById(R.id.speciality);
        }
    }
}
