<h4>Videos</h4>

{{ list_youtube_videos playlistId='PL1gx1q6y_097T-ncqQYP7o4Ju8bERPkhY' maxResults=6 }} 
    <p>{{$video.title}}</p> 
    <p>{{$video.publishedAt}}</p> 
    <p>{{$video.channelId}}</p> 
    {{ foreach $video.thumbnails as $thumbnail }} 
        <p><img src="{{ $thumbnail.url }}" width="{{ $thumbnail.width }}" height="$thumbnail.height"></p> 
    {{ /foreach }} 
{{ /list_youtube_videos }}
