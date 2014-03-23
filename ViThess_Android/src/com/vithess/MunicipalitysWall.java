package com.vithess;

import java.util.ArrayList;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

public class MunicipalitysWall extends Fragment {

	ListView municipalitysListView ;
	View view;
	ArrayList<Message> messages = new ArrayList<Message>();
	
	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

		view = inflater.inflate(R.layout.municipalitys_wall, container, false);
		initializeList();       

		return view;
	}
	
	private void initializeList() {
		
		// 1. pass context and data to the custom adapter
        MessageArrayAdapter maa = new MessageArrayAdapter(getActivity(), messages);
 
        // 2. Initialize the users wall
        municipalitysListView = (ListView) view.findViewById(R.id.municipalitys_list);
 
        // 3. Assign adapter to ListView
        municipalitysListView.setAdapter(maa);        
        
	}
	
	public void loadMessages(String result) {
		try {
			JSONObject jsonObject = new JSONObject(result);
			JSONArray json = jsonObject.getJSONArray("messages");
			
			messages = new ArrayList<Message>();
			Log.d("Messages","Messages");
			for(int i=0;i<json.length();i++){    
			    JSONObject e = json.getJSONObject(i);
			    
			    int message_id       = Integer.parseInt(e.getString("message_id"));
			    String message_title = e.getString("message_title");
			    String message_text  = e.getString("message_text");
			    int message_views    = Integer.parseInt(e.getString("message_views"));
			    int message_up_votes = Integer.parseInt(e.getString("message_up_votes"));
			    int message_down_votes = Integer.parseInt(e.getString("message_down_votes"));
			    double distance = Double.parseDouble(e.getString("distance"));
			    distance = Math.round(distance * 100.0) / 100.0;
			    String date = e.getString("message_creation_timestamp");			    
			    
			    Message msg =new Message (message_id, message_title, message_text, message_up_votes,
			    		message_down_votes, message_views, distance, "", "", date);
			    messages.add(msg);
			}
			
			initializeList();        
	        
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}		
	}
}