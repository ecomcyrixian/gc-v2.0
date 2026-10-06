<div id="gcheck-booking-widget">
<div class="book-a-demo-container"><div class="title"><span>Book a Demo</span></div><div class="description">Faster hiring, cleaner compliance, less manual work. In 30 minutes, see the platform in action, get pricing tailored to your hiring volume, and leave with a clear plan for integrating GCheck with your hiring workflow.</div></div>
<div class="demo-calendar">
<!-- Calendly inline widget begin -->
<div class="calendly-inline-widget" data-url="https://calendly.com/gcheck/discovery" data-auto-load="false" style="min-width:320px;height:900px;"></div>
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
<script nitro-exclude>(function(){function safeGet(key){try{return sessionStorage.getItem(key)||"";}catch(e){return "";}}function getUrlParam(name){return new URLSearchParams(window.location.search).get(name)||"";}function buildVisitedPagesParam(raw){if(!raw)return "";var arr;try{arr=JSON.parse(raw);}catch(e){return "";}if(!Array.isArray(arr))return "";var paths=[];for(var i=0;i<arr.length;i++){var url="";if(arr[i]){if(arr[i].url){url=arr[i].url;}}var path=url;try{path=new URL(url).pathname||"/";}catch(e){}paths.push(path);}for(var count=paths.length;count>=0;count--){var subset=paths.slice(0,count).join("|");var encoded="";try{encoded=btoa(subset);}catch(e){encoded="";}if(encoded.length<=255){return encoded;}}return "";}function initCalendlyWithParams(){if(!window.Calendly){setTimeout(initCalendlyWithParams,100);return;}var baseUrl="https://calendly.com/gcheck/discovery";var gaClientId=safeGet("gaClientId");var channelGroup=safeGet("defaultChannelGroup");var referrer=safeGet("referrer");var visitedPagesRaw=safeGet("visitedPagesRecent5");var visitedPagesParam=buildVisitedPagesParam(visitedPagesRaw);var utm={utmSource:getUrlParam("utm_source"),utmMedium:channelGroup?channelGroup.substring(0,255):"",utmCampaign:getUrlParam("utm_campaign"),utmContent:visitedPagesParam,utmTerm:referrer?referrer.substring(0,255):""};var finalUrl=baseUrl;if(gaClientId){finalUrl+="?salesforce_uuid="+encodeURIComponent(gaClientId.substring(0,255));}Calendly.initInlineWidget({url:finalUrl,parentElement:document.querySelector('.calendly-inline-widget'),utm:utm});}initCalendlyWithParams();})();</script>
<!-- Calendly inline widget end -->
</div>
</div>
<div id="gcheck-booking-confirmed" style="display:none;">
<div class="booking-confirmed-container">
<div class="_header-container">
<figure class="wp-block-video animation-figure"><video autoplay="autoplay" loop="loop" muted="" width="300" height="150"><source src="https://gcheck.com/wp-content/uploads/2026/04/04163.mp4" />Your browser does not support the video tag.</video></figure>
<div class="_header-text">
<div class="_header">
<div class="snippet">You're all set!</div>
<div class="title">Your meeting is on the calendar.</div>
</div>You'll receive a calendar invite and video link with any prep details.</div></div>
<div class="_booking-info-container">
<div class="_sub-container">
<div class="_text">Don't see it on your calendar yet?</div>
<div class="_sub-text">Add it manually with the button here.</div>
</div>
<div class="add-to-calendar-wrapper" style="position:relative; max-width:280px; align-self:flex-start;">
  <button id="add-to-calendar-btn" class="button blue" style="width:100%; display:flex; align-items:center; justify-content:center; gap:8px; border-radius:6px; padding:12px 20px; font-size:15px; cursor:pointer; position:relative; z-index:2;">Add to calendar</button>
<div id="calendar-options" style="position:absolute; top:calc(100% + 0px); left:0; width:100%; background:#fff; border:1px solid #e2e2e2; border-radius:10px; overflow:hidden; display:none; box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:3;">
    <a id="cal-google" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:10px; padding:12px 16px; font-size:14px; color:#222; text-decoration:none; border-bottom:1px solid #eee;">Google Calendar</a><a id="cal-outlook" target="_blank" rel="noopener" style="display:flex; align-items:center; gap:10px; padding:12px 16px; font-size:14px; color:#222; text-decoration:none; border-bottom:1px solid #eee;">Outlook</a><a id="cal-ics" download="gcheck-meeting.ics" style="display:flex; align-items:center; gap:10px; padding:12px 16px; font-size:14px; color:#222; text-decoration:none;">Apple / other (.ics)</a>
  </div>
</div>
</div><div class="separator"></div>
<div class="closing-text"><strong>Need to reschedule?</strong>
Use the invite links or reply to the email and we'll help.</div></div>
</div>
<script nitro-exclude>
(function() {
  function loadAddToCalendar(eventUri, inviteeUri) {
    var eventUuid = eventUri.split('/').pop();
    var inviteeUuid = inviteeUri.split('/').pop();
    var btn = document.getElementById('add-to-calendar-btn');
    fetch('/wp-json/gcheck/v1/calendly-event?event_uuid=' + eventUuid + '&invitee_uuid=' + inviteeUuid)
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (!data.start_time || !data.end_time) {
          btn.style.display = 'none';
          return;
        }
        var start = new Date(data.start_time);
        var end = new Date(data.end_time);
        var title = data.name || 'GCheck Discovery Call';
        var desc = 'Your GCheck demo call.';
        function formatUTC(d) {
          return d.toISOString().replace(/[-:]/g, '').split('.')[0] + 'Z';
        }
        function buildICS(start, end, title, desc) {
          var ics = [
            'BEGIN:VCALENDAR','VERSION:2.0','BEGIN:VEVENT',
            'DTSTART:' + formatUTC(start),
            'DTEND:' + formatUTC(end),
            'SUMMARY:' + title,
            'DESCRIPTION:' + desc,
            'END:VEVENT','END:VCALENDAR'
          ].join('\r\n');
          return 'data:text/calendar;charset=utf8,' + encodeURIComponent(ics);
        }
        document.getElementById('cal-google').href =
          'https://calendar.google.com/calendar/render?action=TEMPLATE&text=' + encodeURIComponent(title) + '&dates=' + formatUTC(start) + '/' + formatUTC(end) + '&details=' + encodeURIComponent(desc);
        document.getElementById('cal-outlook').href =
          'https://outlook.office.com/calendar/0/deeplink/compose?subject=' + encodeURIComponent(title) + '&startdt=' + start.toISOString() + '&enddt=' + end.toISOString() + '&body=' + encodeURIComponent(desc);
        document.getElementById('cal-ics').href = buildICS(start, end, title, desc);
        btn.addEventListener('click', function() {
          var opts = document.getElementById('calendar-options');
          opts.style.display = opts.style.display === 'none' ? 'block' : 'none';
        });
      })
      .catch(function() {
        btn.style.display = 'none';
      });
  }
  window.addEventListener('message', function(e) {
    if (e.data && e.data.event === 'calendly.event_scheduled') {
      var eventUri = e.data.payload.event.uri;
      var inviteeUri = e.data.payload.invitee.uri;
      window.dataLayer = window.dataLayer || [];
      dataLayer.push({
        event: 'booking_confirmed',
        calendly_event_uri: eventUri,
        calendly_invitee_uri: inviteeUri
      });
      document.getElementById('gcheck-booking-widget').style.display = 'none';
      document.getElementById('gcheck-booking-confirmed').style.display = 'block';
      loadAddToCalendar(eventUri, inviteeUri);
    }
  });
})();
</script>