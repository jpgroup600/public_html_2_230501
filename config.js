function functionName(data,string)
{
    string = String(string)
    var cookieValue = document.cookie
  .split('; ')
  .find(row => row.startsWith(string))
  .split('=')[1];

var jsonData = JSON.parse(cookieValue);
}