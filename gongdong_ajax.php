
<? 

session_start();
// POST 방식으로 전달된 name 값 가져오기


if($_POST['data'])
{
    $_SESSION['data_save'] = $_POST['data'];
    $name = $_SESSION['data_save'];
    echo "들어옴";
}




$_SESSON['test'] = "test";
$test = $_SESSION['test'];


echo $test;
// name 값 출력
echo "POST 방식으로 전달된 name 값: $name<br>";

// foreach ($name["data"] as $item) {
//     echo $item["certStrData"]["derStr"] . "<br>";
//   }


//print_r( $name['data'][0]['certStrData']['derStr']);




?>


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const url = "https://api.taxget.co.kr:25551/detectCert";



let todo = null; // 초기값으로 null을 설정

let loading = true;

axios.post(url)
  .then(function (response) {
    data = response.data;
    console.log("찐코드",data);
    console.log("짭코드 왜 안되냐고요 아저씨야 ", console.log(data['data'][0]['certStrData']['derStr']));

    short_data = data['data'][0]['certStrData']['derStr'];

    test_data = "hello_wrold"

    $.ajax({
  url: 'your-php-file.php',
  type: 'POST',
  data: { data: yourData },
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




</script>



<? 

session_start();
// POST 방식으로 전달된 name 값 가져오기


if($_POST['data'])
{
    $_SESSION['data_save'] = $_POST['data'];
    $name = $_SESSION['data_save'];
    echo "들어옴";
}




$_SESSON['test'] = "test";
$test = $_SESSION['test'];


echo $test;
// name 값 출력
echo "POST 방식으로 전달된 name 값: $name<br>";

// foreach ($name["data"] as $item) {
//     echo $item["certStrData"]["derStr"] . "<br>";
//   }


//print_r( $name['data'][0]['certStrData']['derStr']);




?>


<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const url = "https://api.taxget.co.kr:25551/detectCert";



let todo = null; // 초기값으로 null을 설정

let loading = true;

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
            data: test_data
        },
        success: function (response) {
            //console.log(response);
        },
        error: function (xhr, status, error) {
            //console.error(error);
        }
        });
    })
    .catch(function (error) {
        console.log(error);
        loading = false;
    });




</script>



