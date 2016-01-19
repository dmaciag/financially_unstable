<?php
  session_start();
  require '../functions.php';
  if( !$_SESSION['is_logged_in'] ){
    if( !redirect_signin() ) die('Something went wrong on the messenger page.');
  }
?>
<!DOCTYPE html>
<html lang="en" ng-app="messenger">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Messenger</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/messenger.css" type="text/css" rel ="stylesheet">
    <script src="../node_modules/angular/angular.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular-material-icons/0.6.0/angular-material-icons.min.js"></script>
    <script src="../js/jquery.js"></script>
  </head>
  <body ng-controller="friends_and_messagesCtrl">
    <div class="left_panel">
      <form ng-submit="submit_user()" ng-controller="usersCtrl">
        <div id="search_user_container">
          <div id="search_results">
            <table id="users_table" class="table table-bordered table-hover">
              <thead>
                <tr id="users_table_input_row">
                  <th><input id="users_table_input" type="text" ng-model="search_query" ng-keyup="search_keyup($event)" placeholder="Request a friend"/></th>
                </tr>
              </thead>
              <tbody>
                <tr class="slide" ng-show="message">
                  <td>message: {{message}}</td>
                </tr>
                <tr ng-repeat="user in users | user_search_filter:search_query">
                  <td ng-click="count = count +1" ng-init="count=0">{{user.username}} , {{count}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
    <div class="middle_panel" ng-controller="friends_and_messagesCtrl">
      <div class="messages_body" id="messages_body_id">
        <div class="message" ng-class="message_obj.sender" ng-repeat="message_obj in all_messages track by $index">{{message_obj.message}}</div>
      </div>
      <div class="new_message_body">
        <textarea ng-keydown="send_message($event)" ng-model="the_message" id="new_message_textarea" wrap="soft" placeholder="Enter your message." maxlength="2000" type="text"></textarea>
        {{the_message}}
      </div>
    </div>
    <div class="right_panel">
      <button id="settings_button" onclick="window.location.href='./settings.php'" class="btn btn-default">Settings</button>
      <button id="logout_button" onclick="window.location.href='./logout.php'" class="btn btn-default">Logout</button>
      <div id="incoming_friend_requests" ng-controller="friend_requestsCtrl">
        <table id="incoming_friend_requests_table" class="table table-bordered table-hover table-condensed">
          <thead class="table table-bordered table-hover">
            <tr>
              <th>Friend Requests</th>
            </tr>
          </thead>
          <tbody id="friend_request_table_body">
            <tr ng-if="!has_friend_requests">
              <td>{{warning_message}}</td>
            </tr>
            <tr ng-if="has_friend_requests" ng-repeat="friend_request in friend_requests">
              <td>{{friend_request.name}}
                <div ng-if="has_friend_requests" id="friend_request_buttons">
                  <ng-md-icon ng-click="accept_friend_request(friend_request.name)" icon="add" style="fill:green" size="15"></ng-md-icon> 
                  <ng-md-icon ng-click="reject_friend_request(friend_request.name)" icon="clear" style="fill:red" size="15"></ng-md-icon>
                </div> 
              </td> 
            </tr>
          </tbody>
        </table>
      </div>
      <div>
        <table id="friends_table" class="table table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>Your Friends</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="friend in friends | orderBy : 'name' " ng-click="selected_friend();">
              <td>{{friend.name}}</td> 
            </tr>
          </tbody>
        </table>
        {{friend_body_message}}
      <div>
    </div>
    <script src="../js/messenger.js"></script>
  </body>
</html>