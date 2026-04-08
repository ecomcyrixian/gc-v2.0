<?php
/**
 * Microsoft Advertising UET (Universal Event Tracking) + Consent Mode default.
 * Consent update (granted) runs from assets/js/bing-consent.js when the user accepts.
 */
?>
<script>
(function(w,d,t,u,o)
{
  w[u]=w[u]||[],
  o.ts=(new Date).getTime();
  var n=d.createElement(t);
  n.src="https://bat.bing.net/bat.js?ti="+o.ti+("uetq"!=u?"&q="+u:""),
  n.async=1,
  n.onload=n.onreadystatechange=function()
  {
    var s=this.readyState;
    s&&"loaded"!==s&&"complete"!== s||(o.q=w[u], w[u]=new UET(o), w[u].push("pageLoad"), n.onload=n.onreadystatechange=null)
  };
  var i=d.getElementsByTagName(t)[0];
  i.parentNode.insertBefore(n,i);
})(window, document, "script", "uetq", {
  ti:"97236412",
  enableAutoSpaTracking:true
});
</script>
<script>
  window.uetq=window.uetq||[];
  window.uetq.push('consent', 'default', {
    'ad_storage': 'denied',
  });
</script>
<script>
  function uet_report_conversion() {
    window.uetq = window.uetq || [];
    try {
      if (typeof localStorage !== 'undefined' && localStorage.getItem('gc_uet_ad_storage_consent') !== 'granted') {
        return;
      }
    } catch (e) {
      return;
    }
    window.uetq.push("event", "request_quote", {"revenue_value":1,"currency":"USD"});
  }
</script>
