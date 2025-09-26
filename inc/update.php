<?php
add_action('wp_ajax_update_repeater', 'my_update_repeater');
// add_action('wp_ajax_nopriv_update_repeater', 'my_update_repeater'); // nur wenn Gäste dürfen

function my_update_repeater() {
  // optional, aber empfohlen:
  // check_ajax_referer('my_nonce', 'nonce');

  $post_id = intval($_POST['post_id'] ?? 0);
  if (!$post_id ) {
    wp_send_json_error('Keine Berechtigung', 403);
  }

  // JSON-String in Array umwandeln
  $incoming_json = wp_unslash($_POST['repeater'] ?? '');
  $incoming_rows = json_decode($incoming_json, true);

  if (!is_array($incoming_rows)) {
    wp_send_json_error('repeater ist kein gültiges JSON', 400);
  }


  unset($row);

  // gesamten Repeater schreiben
  update_field('days', $incoming_rows, $post_id);

  wp_send_json_success(['post_id' => $post_id, 'rows' => $incoming_rows]);
}
