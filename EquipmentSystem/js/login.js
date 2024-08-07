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
