package com.vithess;

import android.annotation.SuppressLint;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class Message {
	
	private int id;
	private String title;
	private String text;
	private String teaser;
	private int likes=0;
	private int dislikes=0;
	private int views=0;
	private double metersAway=0;
	private String username;
	private String address;
	private String date;
	

	
	public Message(int id, String title, String teaser, int likes, 
			int dislikes, int views, double distance, String username, String address, String date) {
		this.id          = id;
		this.title       = title;
		this.teaser      = teaser;
		this.likes       = likes;
		this.dislikes    = dislikes;
		this.views       = views;
		this.metersAway  = distance;
		this.username    = username;
		this.address     = address;
		this.date        = date;
	}
	
	public Message(String title, String text) {
		this.title = title;
		this.text = text;
	}
	
	public int getId() { return this.id; }
	public String getTitle() { return this.title; }
	public String getTeaser() { return this.teaser;}
	public String getText() { return this.text; }
	public int getLikes() { return this.likes; }
	public int getDislikes() { return this.dislikes; }
	public int getViews() { return this.views; }
	public double getMetersAway() { return this.metersAway; }
	public String getUsername() { return this.username; }
	public String getAddress() { return this.address; }
	
	@SuppressLint("SimpleDateFormat")
	public String getDate() { 
		if(this.date!="" && this.date!=" " && this.date!=null){
			String d="";
			try {
				SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss");
				Date startDate = sdf.parse(this.date);
				SimpleDateFormat sdf2 = new SimpleDateFormat("dd/MM/yyyy");
				d=sdf2.format(startDate);
			} catch (ParseException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
			return d;
		} else
			return this.date; 
	}
	
	public void setText(String text) { this.text=text; }

}
