<?php 
	
	ini_set('allow_url_fopen','ON');
	$lottonumber = 891;

	$daily = array('일','월','화','수','목','금','토'); //요일을 배열로
	$date = date('y.m.d H:i:s');
	
	$weekday = $daily[date('w')];  
	
	$fulldate = $date."(".$weekday.")";
	 
	//print_r($fulldate); //날짜 나타내기

	if($weekday == "일") {
		++$lottonumber;
		print_r($lottonumber);
	} else {
		
	}

	$json = file_get_contents("https://www.nlotto.co.kr/common.do?method=getLottoNumber&drwNo=$lottonumber");
	//print_r($json);
	$result_json = json_decode($json, true);
	//print_r($result_json); //전체 결과 JS 출력


?>

<html>

<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style>
		@import url(https://cdn.jsdelivr.net/gh/moonspam/NanumSquare@1.0/nanumsquare.css);
		
		html, body {
			background: linear-gradient(45deg, #ad5389, #3c1053);
			color: white;
			font-family: 'NanumSquare', sans-serif;
		}

		#lotto_number {
			font-size: 35px;
			text-align: center;
		}

		#lotto_date {
			font-weight: 100;
			font-size: 20px;
			text-align: center;
			line-height: 2.3em;
		}

	</style>


	<script language="javascript" type="text/javascript">
		
		/*function lotto_input_select() {
			var lotto_result = $("#lotto_input_result option:selected").val();
			//alert(lotto_result);
		}*/

		var lottoNumbers  = new Array(45);

		function lotto_input_select() {

			var GameCnt = $("#lotto_input_result option:selected").val();
			var loopcnt = 0;
			var arIndex = 0;
			var dispObj = document.getElementById('result_lotto_javascript');
			dispObj.innerHTML = "";
			var displayStr = '';

			while (GameCnt) {
				
				displayStr = '';
				loopcnt = 0;
				for (i = 0; i < lottoNumbers.length; i++)
					lottoNumbers[i] = false;

				while (loopcnt <= 7) {
					arIndex = ((Math.random() * 100) % 45).toString().split('.')[0];
					if (lottoNumbers[arIndex] == false) {
						lottoNumbers[arIndex] = true;
						loopcnt++;
						if (loopcnt == 7)
							break;
					}
				}

				for (j = 0; j < lottoNumbers.length; j++) {
					if (lottoNumbers[j] == true) {
						displayStr += (j + 1).toString();
						displayStr += ' </div>';
					}
				}

				displayStr += " <br><br>";
				dispObj.innerHTML += displayStr;
				GameCnt--;
			}

			$(document).ready(function() {
				$("#lotto_result_modal_main").click(function(){
					$("#lotto_number_modal_input").modal("hide");
					$("#lotto_result_modal_sub").modal("show");				
				});
			});

		} //로또 정산 마무리

	</script>

</head>

<body>

<form id="lotto_frm" name="lotto_frm">

	<div id="lotto_date">
		<?php 
			echo "회차: ";
			print_r($result_json['drwNo']); // 회차
			echo "회 <br>";
			echo "추첨날짜: ";
			print_r($result_json['drwNoDate']); //추첨날짜
		?>
	</div>

	<div id="lotto_number">
		<?php
			echo " ";
			print_r($result_json['drwtNo1']); // 1번째 번호
			echo " ";
			print_r($result_json['drwtNo2']); // 2번째 번호
			echo " ";
			print_r($result_json['drwtNo3']); // 3번째 번호
			echo " ";
			print_r($result_json['drwtNo4']); // 4번째 번호
			echo " ";
			print_r($result_json['drwtNo5']); // 5번째 번호
			echo " ";
			print_r($result_json['drwtNo6']); // 6번째 번호
			echo " + ";
			print_r($result_json['bnusNo']); // 보너스번호
		?>
	</div>

	<div id="lotto_button">
		<button type="button" class="btn btn-outline-light" color="white" data-toggle="modal" data-target="#lotto_number_modal_input">로또번호 조합</button>
	</div>


	<div class="modal fade" id="lotto_number_modal_input" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" style="color: black;">몇 개를 조합해드릴까요 ?</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
				<label for="exampleFormControlSelect1">개수</label>
				<select class="form-control" id="lotto_input_result">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				  <option value="5">5</option>
				  <option value="6">6</option>
				  <option value="7">7</option>
				  <option value="8">8</option>
				  <option value="9">9</option>
				  <option value="10">10</option>

				</select>

				
			  </div>

			  <p style="color: #333; font-size: 9px;"> ※ 본 결과는 정확성을 보장하지 않으며, 서비스를 통해 추출하여 구매하시는 것은 책임을 지지 않습니다. 단순 재미용으로 추출 서비스를 이용하시기 바랍니다. </p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
			<button type="button" class="btn btn-primary" onclick="lotto_input_select()" id="lotto_result_modal_main">로또번호 조합</button>
		  </div>
		</div>
	  </div>
	</div>


	<div class="modal fade" id="lotto_result_modal_sub" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" style="color: black;">조합이 성공적으로 되었어요.</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
				<div id="result_lotto_javascript" style="color: #333;">
					
				</div>
				
			</div>

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
			
		  </div>
		</div>
	  </div>
	</div>


</form>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>


</html>


