<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/app.css">
  <title>POSTS</title>
</head>
<body>
  
  <div id="posts">
  
    <div id="Post_1"  class="post" data-post-id="1">
      <div>This is post one</div>
      <button class="like" onclick="like(); return false">like</button>
      <button class="dislike" onclick="dislike(); return false">dislike</button>    
    </div>

    <div id="Post_2"  class="post" data-post-id="2">
      <div>This is post one</div>
      <button class="like" onclick="like(); return false">like</button>
      <button class="dislike" onclick="dislike(); return false">dislike</button>    
    </div>

    <div id="Post_3"  class="post" data-post-id="3">
      <div>This is post one</div>
      <button class="like" onclick="like(); return false">like</button>
      <button class="dislike" onclick="dislike(); return false">dislike</button>    
    </div>

  
  </div>


  <script>
    async function like(){
      let button = event.target     
      let button_parent = button.parentNode
      // let post_id = button_parent.id
      let post_id_from_data_attr = button_parent.getAttribute("data-post-id")
      console.log(post_id_from_data_attr) 
      let conn = await fetch(`/posts/${post_id_from_data_attr}/1`, {
        method:"POST"
      })
      // if( conn.status != 200 ){ alert("something went wrong") }
      if( ! conn.ok ){ 
        alert("sorry, we are updating our servers") 
        return
      }
      
      button_parent.querySelector(".like").classList.add('hide')
      button_parent.querySelector(".dislike").classList.remove('hide')
    }

    async function dislike(){
      let button = event.target 
      let button_parent = button.parentNode     
      let conn = await fetch('/posts/1/0', {
        method:"POST"
      })
      // if( conn.status != 200 ){ alert("something went wrong") }
      if( ! conn.ok ){ 
        alert("sorry, we are updating our servers") 
        return
      }
      button_parent.querySelector(".dislike").classList.add('hide')
      button_parent.querySelector(".like").classList.remove('hide')
    }



  </script>


</body>
</html>