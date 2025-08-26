Read theme documentation to set up the theme.
In main (downloaded) theme package is 'documentation' folder. Unzip 'documentation' folder and open index.html
THX

EVENT MANAGER 
Settings > Formatting

> Events Page > Default event list format header

<table cellpadding="0" cellspacing="0" class="events-table" >
<tbody


____

> Events Page > Default event list format

<tr>
<td class="date">
#_EVENTDATES
</td>
<td class="list_text">
#_EVENTIMAGE{130,130}
<h5>#_EVENTLINK</h5>
{has_location}<i>#_LOCATIONNAME, #_LOCATIONTOWN #_LOCATIONSTATE - #_EVENTTIMES</i>{/has_location}
#_EVENTEXCERPT
</td>
</tr>


____

> Single Event Page > Single event page format

<div class="event_header">
#_LOCATIONMAP
<h5> #_EVENTDATES<br /><i>#_EVENTTIMES</i>
</h5>
{has_location}
<p>
	<strong>Location</strong><br/>
	#_LOCATIONLINK
</p>
{/has_location}
</div>

<br style="clear:both" />
#_EVENTNOTES
{has_bookings}
<h3>Bookings</h3>
#_BOOKINGFORM
{/has_bookings}