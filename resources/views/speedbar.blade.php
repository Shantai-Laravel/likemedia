<div class="speedbar">
    <ul>
       <!--  @if(!is_null(Request::segment(6)))
            <?php
                $segment1 = trans('variables.home');
                $segment2 = $modules_name->{'name_'.$lang};
                $segment3 = Request::segment(4);
                $segment4 = Request::segment(5);
            ?>
        @elseif(!is_null(Request::segment(5)) || !is_null(Request::segment(4)))
            <?php
                $segment1 = trans('variables.home');
                $segment2 = $modules_name->{'name_'.$lang};
                $segment3 = Request::segment(4);
                $segment4 = Request::segment(5);
            ?>
        @elseif(!is_null(Request::segment(3)))
            <?php
                $segment1 = trans('variables.home');
                $segment2 = $modules_name->{'name_'.$lang};
                $segment3 = '';
                $segment4 = '';
            ?>
        @else
            <?php
                $segment1 = trans('variables.home');
                $segment2 = '';
                $segment3 = '';
                $segment4 = '';
            ?>
        @endif -->
           <!--  {!! Breadcrumbs::render(Request::segment(count(Request::segments())), $segment1, $segment2, str_replace("-options","",$segment3), $segment4, $lang) !!} -->
    </ul>
</div>
