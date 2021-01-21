<?php 
include "header.php";

?>

<h1 id="about">Welcome to Flag!</h1>
<p>Flag is a great open source video sharing website that you never knew you needed.</p>

<div style="width:75%">
<h2>API</h2>

Most of Flag's APIs do not require a key, meaning that you can build apps without wasting time on getting
tokens.

<table class="table">
  <thead>
    <tr>
      <th>Request Type</th>
      <th>Path</th>
      <th>Params</th>
      <th>Description</th>
      <th>API Key Required?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>GET</th>
      <td>/api/v1/comments</td>
      <td>id</td>
      <td>Returns comments of a video</td>
      <td>No</td>
    </tr>
    <tr>
      <th>GET</th>
      <td>/api/v1/users</td>
      <td>username</td>
      <td>Returns data on a requested username</td>
      <td>No</td>
    </tr>
    <tr>
      <th>GET</th>
      <td>/api/v1/videos</td>
      <td>id</td>
      <td>Returns video metadata</td>
      <td>No</td>
    </tr>
     <tr>
      <th>GET</th>
      <td>/api/v1/search</td>
      <td>q</td>
      <td>Search all videos for a keyword (BETA)</td>
      <td>No</td>
    </tr>
    <tr>
      <th>GET</th>
      <td>/api/v1/stats</td>
      <td>id</td>
      <td>Returns statistics of a video</td>
      <td>No</td>
    </tr>
    <tr>
      <th>POST</th>
      <td>/api/v1/delete</td>
      <td>id</td>
      <td>Deletes a video</td>
      <td>Yes (user token)</td>
    </tr>
    <tr>
      <th>POST</th>
      <td>/api/v1/settings</td>
      <td>announce, comments, current</td>
      <td>Returns or updates user settings</td>
      <td>Yes (user token)</td>
    </tr>
</div>
<?php