<script>

var cookieValue = document.cookie
  .split('; ')
  .find(row => row.startsWith('user_data='))
  .split('=')[1];

var jsonData = JSON.parse(cookieValue);
console.log(jsonData['userName']);
</script>