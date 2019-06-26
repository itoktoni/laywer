
<aside id="sidebar-right" class="sidebar-right">
    <div class="nano">
        <div class="nano-content">
            <a href="#" class="mobile-close visible-xs">
                <h5 style="background-color: red;width: 80px;text-align: center;padding:7px 5px 7px 5px;color: white;border-radius: 5px;font-weight: bold;">CLOSE</h5>
            </a>
            <div class="sidebar-right-wrapper">
                <div class="sidebar-widget widget-calendar">
                    <div>
                        <div class="btn btn-default btn-lg btn-block">
                            Access Module 
                        </div> 
                    </div>
                    <ul style="margin-top: -15px;">
                        @php 
                        $access = Auth::User()->username.'_group_access'; 
                        @endphp
                        @if(isset($group_list))
                        @foreach($group_list as $group)
                        <li>
                            <div class="col-xs-12">
                                <a onclick="location.href = '{{ route('access_group',[$group->group_module_code]) }}';" class="mb-xs mt-xs mr-xs btn btn-{{ (Session($access) == $group->group_module_code ? 'primary' : 'default') }} btn-block">
                                    <h6 class="text-right text-dark{{ (Session($access) == $group->group_module_code ? '-inverse' : '') }}"> {{ $group->group_module_name }}</h6>
                                </a>
                            </div>
                        </li>
                        @endforeach
                        @if(Auth::user()->group_user == 'developer')
                        <li>
                            <div class="col-xs-12">
                                <a onclick="location.href = '{{ route('reboot') }}';" class="mb-xs mt-xs mr-xs btn btn-danger btn-block">
                                    <h6 class="text-right text-dark-inverse"> Reboot </h6>
                                </a>
                            </div>
                        </li>
                        @endif
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>