export function getCookie(name) {
    let cookieValue = null;
    if (document.cookie && document.cookie !== '') {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.substring(0, name.length + 1) === name + '=') {
                cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                break;
            }
        }
    }
    return cookieValue;
}

export function getUserId() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: 'php/getUserId.php',
        type: 'POST',
        success: function(data) {
          resolve(data);
        },
        error: function() {
          reject(-1);
        }
      });
    });
}

export function getUserid() {
    const userId = getUserId()
    .then(userId => {
      const userid = userId;
    })
    .catch(error => {
      const userid = -1;
    });
    return userid;
}
  