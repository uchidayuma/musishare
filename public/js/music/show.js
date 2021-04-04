function like(id, userId){
  var token = document.querySelector('meta[name="csrf-token"]').content
  // FetchAPIのオプション準備
  var params  = {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-CSRF-TOKEN": token 
    },
    // リクエストボディ
    body: JSON.stringify({ id: id, user_id: userId})
  };
  fetch('/music/ajax/like', params )
    .then(res => res.json())
      .then(function(data) {
        if(data.result === 'like'){
          // いいね！した場合
          document.getElementById('like-icon').classList.remove('far')
          document.getElementById('like-icon').classList.add('fas', 'color-pink')
        }else{
          document.getElementById('like-icon').classList.add('far')
          document.getElementById('like-icon').classList.remove('fas', 'color-pink')
          // いいね！を外した場合

        }
      })
    .catch((reason) => {
      alert('通信が失敗しました。時間を空けてアクセスしてください。')
    });
}