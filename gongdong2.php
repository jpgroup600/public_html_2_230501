<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>My Page</title>
  
</head>

<body>
  <!-- HTML 코드를 작성합니다. -->
  <div id="result"> 
    
  </div>

  <?php 
  session_start();

  $data = $_SESSION['send_data'];
  $user_count = $_GET['count'];
  
  $count = 0;


foreach ($data["data"] as $item) {
    echo "<a href=?count=$count>". $item["infoData"]["ownerName"] . "</a> <br>";
     $count++;
      }

if(isset($user_count)){
  // echo $data['data'][$user_count]['certStrData']['derStr']."<br>";
  // echo $data['data'][$user_count]['certStrData']['keyStr'];

  $_SESSION['der_file'] = $data['data'][$user_count]['certStrData']['derStr'];
  $_SESSION['key_file'] = $data['data'][$user_count]['certStrData']['keyStr'];
} 

?>


  


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    // AJAX 요청을 처리하는 JavaScript 코드를 작성합니다.

    const url = "https://api.taxget.co.kr:25551/detectCert";

    axios.post(url)
  .then(function (response) {
    data = response.data;
    console.log("찐코드",data);
    console.log("짭코드 왜 안되냐고요 아저씨야 ", console.log(data['data'][0]['certStrData']['derStr']));

    short_data = data['data'][0]['certStrData']['derStr'];

    test_data = "hello_wrold"

    $.ajax({
        url: "gongdong.php",
        method: "POST",
        data: {
            data: data
        },
        success: function (response) {
            //console.log(response);
        },
        error: function (xhr, status, error) {
            //console.error(error);
        }
        });  //ajax 끝


        
    $.ajax({
      url: 'gongdong.php',
      type: 'POST',
      data: { data: data },
      success: function(result) {
        // PHP 파일에서 반환한 응답을 처리합니다.
        $('#result').html(result);
      }
    });


    })


    .catch(function (error) {
        console.log(error);
        loading = false;
    });



    var send_data = "hello_world";

  </script>
</body>
</html>
