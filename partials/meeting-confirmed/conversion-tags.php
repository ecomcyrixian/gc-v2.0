<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$invitee_uuid  = isset( $_GET['invitee_uuid'] )      ? sanitize_text_field( wp_unslash( $_GET['invitee_uuid'] ) )      : '';
$event_name    = isset( $_GET['event_type_name'] )   ? sanitize_text_field( wp_unslash( $_GET['event_type_name'] ) )   : '';
$invitee_name  = isset( $_GET['invitee_full_name'] ) ? sanitize_text_field( wp_unslash( $_GET['invitee_full_name'] ) ) : '';
$invitee_email = isset( $_GET['invitee_email'] )     ? sanitize_email( wp_unslash( $_GET['invitee_email'] ) )          : '';
$event_start   = isset( $_GET['event_start_time'] )  ? sanitize_text_field( wp_unslash( $_GET['event_start_time'] ) )  : '';
$assigned_to   = isset( $_GET['assigned_to'] )       ? sanitize_text_field( wp_unslash( $_GET['assigned_to'] ) )       : '';
?>
<script>
(function() {
  var inviteeUuid = <?php echo wp_json_encode( $invitee_uuid ); ?>;

  if ( inviteeUuid ) {
    var storageKey = 'gc_conv_' + inviteeUuid;
    try {
      if ( sessionStorage.getItem( storageKey ) ) return;
      sessionStorage.setItem( storageKey, '1' );
    } catch(e) {}
  }

  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({
    'event':          'meeting_confirmed',
    'conversion_type': 'booking',
    'event_name':     <?php echo wp_json_encode( $event_name ); ?>,
    'invitee_uuid':   inviteeUuid,
    'invitee_name':   <?php echo wp_json_encode( $invitee_name ); ?>,
    'invitee_email':  <?php echo wp_json_encode( $invitee_email ); ?>,
    'event_start':    <?php echo wp_json_encode( $event_start ); ?>,
    'assigned_to':    <?php echo wp_json_encode( $assigned_to ); ?>
  });

  (function(w,d,t,u,o){
    w[u]=w[u]||[];
    o.ts=(new Date).getTime();
    var n=d.createElement(t);
    n.src='https://bat.bing.net/bat.js?ti='+o.ti+('uetq'!=u?'&q='+u:'');
    n.async=1;
    n.onload=n.onreadystatechange=function(){
      var s=this.readyState;
      if(s&&'loaded'!==s&&'complete'!==s)return;
      o.q=w[u];w[u]=new UET(o);w[u].push('pageLoad');
      n.onload=n.onreadystatechange=null;
    };
    var i=d.getElementsByTagName(t)[0];
    i.parentNode.insertBefore(n,i);
  })(window,document,'script','uetq',{ti:'97236412',enableAutoSpaTracking:false});

  window.uetq = window.uetq || [];
  window.uetq.push('event','request_quote',{'revenue_value':1,'currency':'USD'});

})();
</script>
