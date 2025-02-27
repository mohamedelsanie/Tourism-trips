<x-app-layout>
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ $post->image }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ $post->title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{{ __('front/common.home') }} </a></li>
                                <li class="breadcrumb-item"><a href="{{ route('photos') }}">{{ __('front/post_types.photos.title') }} </a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="roberto-news-area section-padding-100-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">

                    {{--<div class="post-thumbnail mb-50">--}}
                        {{--<img src="{{ $post->image }}" alt="{{ $post->title }}">--}}
                    {{--</div>--}}

                    <div class="blog-details-text">
                        <div class="desc">{!! $post->content !!}</div>
                        <br />

                        @if(!empty($post->gallery['link']))
                        <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
                        <!-- Magnific Popup CSS-->
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">

                        <div class="gallery-slider_wrapper">
                            <div class="single-gallery-carousel-content-box owl-carousel owl-theme">
                                @foreach($post->gallery['link'] as $gal)
                                    <a class="item" href="{{ $gal }}">
                                        <img src="{{ $gal }}" alt="{{ $post->title }}"/>
                                    </a>
                                @endforeach
                            </div>
                            <div style="margin:10px 25px 0 25px;">
                                <div class="single-gallery-carousel-thumbnail-box owl-carousel owl-theme">
                                    @foreach($post->gallery['link'] as $gal)
                                        <div class="item" href="{{ $gal }}">
                                            <img src="{{ $gal }}" alt="{{ $post->title }}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Magnific Popup JS-->
                        <script src='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js'></script>
                        @endif
                    </div>

                    <div class="post-author-area d-flex align-items-center justify-content-between mb-50">

                        <div class="author-social-info d-flex align-items-center">
                            <p>{{ __('front/post_types.photo.share') }} :</p>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ getImageLink($post->slug) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ getImageLink($post->slug) }}&text={{ $post->title }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="https://plus.google.com/share?url={{ getImageLink($post->slug) }}" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            <a href="{{ getPageLink(getSetting('contact_page')) }}" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    @if(getSetting('comments_mode') == 'open')
                        @if($post->comments_status == 'open')
                            <div class="comment_area mb-50 clearfix">
                                <h2>@if(!empty($comments)){{ count($comments) }}@else 0 @endif {{ __('front/post_types.comments.title') }}</h2>
                                <ol>
                                    @foreach($comments as $comment)
                                        {{-- show the comment markup --}}
                                        <li class="single_comment_area">
                                            @include('front.news.parent-comment', ['comment' => $comment])
                                        </li>
                                        @if($comment->children->count() > 0)
                                            <ol class="children">
                                                {{-- recursively include this view, passing in the new collection of comments to iterate --}}
                                                @include('front.news.child-comment', ['comments' => $comment->children])
                                            </ol>
                                        @endif
                                    @endforeach
                                </ol>
                            </div>

                            <div class="roberto-contact-form mt-80 mb-100" id="addComment">
                                <h2>{{ __('front/post_types.comments.add') }}</h2>
                                <form action="{{ route('photos.add_comment',$post->slug) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            @auth()
                                            <input type="text" name="name" value="{{ old('name') ? old('name') : auth()->user()->name }}" class="form-control mb-30" placeholder="{{ __('front/post_types.comments.name') }}">
                                            @else
                                            <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control mb-30 @error('name')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.name') }}">
                                            @endif
                                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-12">
                                            @auth()
                                            <input type="email" name="email" value="{{ old('email') ? old('email') : auth()->user()->email }}" class="form-control mb-30" placeholder="{{ __('front/post_types.comments.email') }}">
                                            @else
                                                <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control mb-30 @error('email')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.email') }}">
                                            @endif
                                            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-12">
                                            <textarea name="comment" class="form-control mb-30 @error('comment')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.comment') }}"></textarea>
                                            @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-12">
                                            <ul class="rate-area">
                                                <input type="radio" id="5-star" name="comment_stars" value="5" /><label for="5-star" title="Amazing">5 stars</label>
                                                <input type="radio" id="4-star" name="comment_stars" value="4" /><label for="4-star" title="Good">4 stars</label>
                                                <input type="radio" id="3-star" name="comment_stars" value="3" /><label for="3-star" title="Average">3 stars</label>
                                                <input type="radio" id="2-star" name="comment_stars" value="2" /><label for="2-star" title="Not Good">2 stars</label>
                                                <input type="radio" id="1-star" name="comment_stars" value="1" /><label for="1-star" title="Bad">1 star</label>
                                            </ul>
                                        </div>
                                        <input name="image_id" type="text" class="hidden" value="{{ $post->id }}" />
                                        <div class="col-12">
                                            <button type="submit" class="btn roberto-btn btn-3 mt-15">{{ __('front/post_types.comments.post') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="comment_area mb-50 clearfix">
                                <h3>{{ __('front/post_types.comments.closed') }}</h3>
                            </div>
                        @endif
                    @else
                        <div class="comment_area mb-50 clearfix">
                            <h3>{{ __('front/post_types.comments.closed') }}</h3>
                        </div>
                    @endif

                </div>
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="roberto-sidebar-area pl-md-4">

                        <div class="single-widget-area mb-100">
                            <div class="newsletter-form">
                                <h5>{{ __('front/post_types.widgets.newsletter_title') }}</h5>
                                <p>{{ __('front/post_types.widgets.newsletter_desc') }}</p>
                                <form action="#" method="get">
                                    <input type="email" name="nl-email" id="nlEmail" class="form-control" placeholder="{{ __('front/post_types.widgets.newsletter_email') }}">
                                    <button type="submit" class="btn roberto-btn w-100">{{ __('front/post_types.widgets.newsletter_button') }}</button>
                                </form>
                            </div>
                        </div>


                        <div class="single-widget-area mb-100">
                            <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.news') }}</h4>
                            @foreach(recentNews(4) as $recent)
                                <div class="single-recent-post d-flex">
                                    <div class="post-thumb">
                                        <a href="{{ getNewsLink($recent->slug) }}"><img src="{{ $recent->image }}" alt="{{ $recent->title }}"></a>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <a href="{{ getNewsLink($recent->slug) }}" class="post-author">{{ $recent->created_at->format('Y-m-d') }}</a>
                                            <a href="{{ getCatLink($recent->category->slug) }}" class="post-tutorial">{{ $recent->category->title }}</a>
                                        </div>
                                        <a href="{{ getNewsLink($recent->slug) }}" class="post-title">{{ $recent->title }}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="single-widget-area mb-100 clearfix">
                            <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.tags') }}</h4>
                            <ul class="popular-tags">
                                @foreach(recenttags(4) as $tag)
                                    <li><a href="#">{{ $tag->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="single-widget-area mb-100 clearfix">
                            <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.videos') }}</h4>

                            <ul class="instagram-feeds">
                                @foreach(recentVideos(6) as $video)
                                    <li><a href="{{ getVideoLink($video->slug) }}"><img src="{{ $video->image }}" alt="{{ $video->title }}"></a></li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="roberto-cta-area">
        <div class="container">
            <div class="cta-content bg-img bg-overlay jarallax" style="background-image: url({{ asset('assets/front/img/bg-img/1.jpg') }});">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="cta-text mb-50">
                            <h2>{{ getSetting('contact_title') }}</h2>
                            <h6>{{ getSetting('contact_desc') }}</h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 text-right">
                        <a href="{{ getPageLink(getSetting('contact_page')) }}" class="btn roberto-btn mb-50">{{ __('front/common.contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br />
    <br />
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                /******************/
                var buttonclicked;
                $(".comment-meta .reply").click(function () {
                    if( buttonclicked!= true ) {
                        buttonclicked= true;
                        var commentId = $(this).data('id');
                        var input = $('<input type="text" class="hidden" name="parent" value="'+commentId+'" />');
                        $(".roberto-contact-form form").append(input);
                    }else{
                        $(".roberto-contact-form form input[name='parent']").remove();
                        buttonclicked= false;
                    }
                });

                $(".rate-area label").click(function () {
                    $('html, body').stop().animate({
                        'scrollTop': $('.roberto-contact-form form').offset().top
                    }, 900, 'swing', function () {
                    });

                });
                $('a[href^="#"]').on('click',function (e) {
                    e.preventDefault();
                    var target = this.hash;
                    var $target = $(target);
                    $('html, body').stop().animate({
                        'scrollTop': $target.offset().top
                    }, 900, 'swing', function () {
                        // window.location.hash = target;
                    });
                });
                function singleGalleryCarousel () {
                    if ($('.single-gallery-carousel-content-box').length && $('.single-gallery-carousel-thumbnail-box').length) {

                        var $sync1 = $(".single-gallery-carousel-content-box"), // variable declaration
                            $sync2 = $(".single-gallery-carousel-thumbnail-box"),
                            flag = false,
                            duration = 500;

                        $sync1.owlCarousel({ //function for preview carousel
                            items: 1,
                            rtl:true,
                            margin: 0,
                            nav: false,
                            dots: false
                        })
                            .on('changed.owl.carousel', function (e) {
                                //var currentItem = e.item.index;
                                //alert(currentItem);
                                if (!flag) {
                                    flag = true;
                                    $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                                    flag = false;
                                }
                            });

                        $('.single-gallery-carousel-content-box').magnificPopup({ //function for magnific popup
                            type: 'image',
                            delegate: '.owl-item:not(.cloned) a',
                            closeOnContentClick: false,
                            removalDelay: 500,
                            callbacks: {
                                beforeOpen: function() {
                                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                                    this.st.mainClass = this.st.el.attr('data-effect');
                                }
                            },
                            tLoading: 'Loading image #%curr%...',
                            mainClass: 'mfp-zoom-in mfp-img-mobile',
                            gallery: {
                                enabled: true,
                                navigateByImgClick: true,
                                preload: [0,1]
                            },
                            zoom: {
                                enabled: true,
                                duration: 300
                            },
                            image: {
                                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                                titleSrc: function(item) {
                                    return item.el.attr('title') + '<small></small>';
                                }
                            }
                        });

                        $sync2.owlCarousel({ //function for thumbnails carousel
                            margin: 1,
                            rtl:true,
                            items: 7,
                            nav: true,
                            dots: false,
                            navText:false,
                            center: false,
                            responsive: {
                                0:{
                                    items:2,
                                    autoWidth: false
                                },
                                400:{
                                    items:3,
                                    autoWidth: false
                                },
                                768:{
                                    items:4,
                                    autoWidth: false
                                }
                            },
                        })
                            .on('click', '.owl-item', function () {
                                $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
                            })
                            .on('changed.owl.carousel', function (e) {
                                if (!flag) {
                                    flag = true;
                                    $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                                    flag = false;
                                }
                            });
                    };
                }
                singleGalleryCarousel (); //FUNCTION CALLED HERE
                /******************/
            });
        </script>
    @endsection

    @section('page_title'){{ __('front/post_types.photos.title') }} - {{ $post->title }}@endsection
</x-app-layout>