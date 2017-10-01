var logger = require('../log');
    
var Module = this.Module = function(){};

var members = [];

Module.prototype.onConnect = function(connection) {
  members.push(connection);
};

Module.prototype.onData = function(data, connection){
  for (var i in members) {
    var c = members[i];
    c.send(connection == c ? "You: " + data : data);
  }
};

Module.prototype.onDisconnect = function(connection){
  for (var i in members) {
    var c = members[i];
    if (members == c) {
      members.splice(i, 1);
      break;
    }
  }
};
