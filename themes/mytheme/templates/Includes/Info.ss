<div class="info-blog">
    <ul class="top-info">
      <li><i class="fa fa-calendar"></i> July 30, 2014</li>
      <li><i class="fa fa-comments-o"></i> 2</li>
      <li><i class="fa fa-tags"></i> Properties, Prices, best deals</li>
    </ul>
    <h3>
      <a href="$Link">$Title</a>
    </h3>
      <% if $Teaser %>
        <p>$Teaser</p>
      <% else %>
        <p>$Content.FirstSentence</p>
      <% end_if %>
  </div>
