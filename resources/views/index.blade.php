<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>How to Load content on page scroll in Laravel 9</title>

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">

       <style type="text/css">
       .card{
             margin: 0 auto;
             margin-top: 35px;
       }
       </style>
</head>
<body>
	<div class="container">
		
		@foreach($posts as $post)
			@php
			$id = $post['id'];
			$title = $post['title'];
			$content = $post['content'];
			$link = $post['link'];
			@endphp

			<div class="card w-75 post">
                <div class="card-body" >
                    <h5 class="card-title">{{ $title }}</h5>
                    <p class="card-text">{{ $content }}</p>
                    <a href="{{$link}}" target="_blank" class="btn btn-primary">Read more</a>
                </div>
            </div>
		@endforeach

		<input type="hidden" id="start" value="0">
		<input type="hidden" id="rowperpage" value="{{ $rowperpage }}">
		<input type="hidden" id="totalrecords" value="{{ $totalrecords }}">
	</div>

	<!-- Script -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript">
	checkWindowSize();
	function checkWindowSize(){
		if($(window).height() >= $(document).height()){
			fetchData();
		}
	}

	// Fetch records
	function fetchData(){
		var start = Number($('#start').val());
		var rowperpage = Number($('#rowperpage').val());
		var allcount = Number($('#totalrecords').val());

		start = start + rowperpage;
		if(start <= allcount){
			$('#start').val(start);

			$.ajax({
				url: "{{ route('getPosts') }}",
				data: {start: start},
				dataType: 'json',
				success: function(response){
					$('.post:last').after(response.html).show().fadeIn();

					checkWindowSize();
				}
			});
		}
	}

	$(document).on('touchmove',onScroll); // For mobile
	$(window).scroll(function(){
		onScroll();
	});

	function onScroll(){

		if($(window).scrollTop() > ($(document).height() - $(window).height() - 100 ) ){
			fetchData();
		}
	}
	</script>
</body>
</html>