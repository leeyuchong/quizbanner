var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost:3306",
  user: "lyc",
  password: "90034606",
  database: "scheduleOfClasses"
});

con.connect(function(err) {
  if (err) throw err;
  var sql = "INSERT INTO users (name, address) VALUES ('Company Inc', 'Highway 37')";
  con.query(sql, function (err, result) {
    if (err) throw err;
    console.log("1 record inserted");
  });
});