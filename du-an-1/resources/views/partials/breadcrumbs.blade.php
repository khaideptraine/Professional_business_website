
<style rel="stylesheet" type="text/css">
#crumbs ul {
    margin: 0;
    display: flex;
    justify-content: center;
    padding: 0;
    overflow: hidden;
    width: 100%;
    list-style: none;
}

#crumbs li {
    float: left;
    margin: 0 10px;
}

#crumbs a {
    background: #ddd;
  padding: .7em 1em;
  float: left;
  text-decoration: none;
  color: #444;
  text-shadow: 0 1px 0 rgba(255,255,255,.5);
  position: relative;
}

#crumbs li:first-child a {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

#crumbs li:last-child a {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

#crumbs a:hover {
    background: #e97730;
}

#crumbs li:not(:first-child) > a::before {
    content: "";
    position: absolute;
    top: 50%;
    margin-top: -1.5em;
    border-width: 1.5em 0 1.5em 1em;
    border-style: solid;
    border-color: #ddd #ddd #ddd transparent;
    left: -1em;
}

#crumbs li:not(:first-child) > a:hover::before {
    border-color: #e97730 #e97730 #e97730 transparent;
}

#crumbs li:not(:last-child) > a::after {
  content: "";
  position: absolute;
  top: 50%;
  margin-top: -1.5em;
  border-top: 1.5em solid transparent;
  border-bottom: 1.5em solid transparent;
  border-left: 1em solid #ddd;
  right: -1em;
}

#crumbs li:not(:last-child) > a:hover::after {
    border-left-color: #e97730;
}
</style>
@unless ($breadcrumbs->isEmpty())
<div id="crumbs">
    <ul>
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-home" aria-hidden="true"></i> {{ $breadcrumb->title }}</a></li>
            @else
            <li><a><i class="fa fa-credit-card-alt" aria-hidden="true"></i> {{ $breadcrumb->title }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
@endunless
