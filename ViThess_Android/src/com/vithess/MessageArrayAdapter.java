package com.vithess;

import java.util.ArrayList;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class MessageArrayAdapter extends ArrayAdapter<Message> {
	 
	private final Context context;
    private final ArrayList<Message> messages;

     public MessageArrayAdapter(Context context, ArrayList<Message> messages) {

         super(context, R.layout.list_view_row, messages);

         this.context = context;
         this.messages = messages;
     }

     @Override
     public View getView(int position, View convertView, ViewGroup parent) {

         // 1. Create inflater 
         LayoutInflater inflater = (LayoutInflater) context
             .getSystemService(Context.LAYOUT_INFLATER_SERVICE);

         // 2. Get rowView from inflater
         View rowView = inflater.inflate(R.layout.list_view_row, parent, false);

         // 3. Get the two text view from the rowView
         TextView messageTitle = (TextView) rowView.findViewById(R.id.message_title);
         TextView messageTeaser = (TextView) rowView.findViewById(R.id.message_teaser);
         TextView messageViews = (TextView) rowView.findViewById(R.id.message_views);
         TextView metersAway = (TextView) rowView.findViewById(R.id.meters_away);
         TextView username = (TextView) rowView.findViewById(R.id.username);
         TextView likes =(TextView) rowView.findViewById(R.id.likes);
         TextView dislikes =(TextView) rowView.findViewById(R.id.dislikes);
     
         // 4. Set the text for textView 
         messageTitle.setText(messages.get(position).getTitle());
         messageTeaser.setText(messages.get(position).getTeaser());
         messageViews.setText("  "+messages.get(position).getViews());
         String address = messages.get(position).getAddress();
         if(address!=null && address!="" && address!=" ")
        	 metersAway.setText(address+ " ("+messages.get(position).getMetersAway()+" χμ μακρυά)");
         else
        	 metersAway.setText(messages.get(position).getMetersAway()+" χμ μακρυά");
         String user = messages.get(position).getUsername();
         String text = "";
         if(user!="" && user!=null && user!=" ")
        	 text=text+user+",  ";
         String date = messages.get(position).getDate();
         if(date!="" && date!=" "&& date!=null)
        	 text=text+date;
        username.setText(text);
         likes.setText(messages.get(position).getLikes()+"  ");
         dislikes.setText(messages.get(position).getDislikes()+" ");

         // 5. return rowView
         return rowView;
     }
     
     
     
}
