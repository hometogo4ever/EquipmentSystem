export function checkLoginStatus() {
  $.ajax({
      url: 'php/getUserId.php',
      type: 'POST',
      success: function(data) {
        if (data == 0) {
            $('#container > header > #account').html(
                `<p>로그인이 필요합니다.</p>
                <ul>
                    <li><a href="login.html"><button>로그인</button></a></li>
                    <li><a href="join.html"><button>회원가입</button></a></li>
                </ul>`
            );
        } else {
            $('#container > header > #account').html(
                `<p>환영합니다, ${data}님!</p>
                <ul>
                    <li><a href="php/logout.php"><button id="logout">로그아웃</button></a></li>
                    <li><a href="mypage.html"><button>마이페이지</button></a></li>
                </ul>`);
        }
      },
      error: function() {
          alert('로그인 상태 확인 실패');
      }
  });
}

export function checkLoginStatus2() {
    $.ajax({
        url: 'php/getUserId.php',
        type: 'POST',
        success: function(data) {
            if (data == 0) {
                alert('로그인이 필요합니다.');
                window.location.href = 'login.html';
            }
        },
        error: function() {
            alert('로그인 상태 확인 실패');
        }
    });
}
