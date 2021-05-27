<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/home" id="topnav-dashboard" role="button">
                            <i class="bx bxs-home mr-2"></i><span key="t-dashboards">Dashboards</span> 
                        </a>
                    </li>

                    @if(Auth::user()->type == 'Administrator')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/agencies" id="topnav-dashboard" role="button">
                            <i class="bx bx-news mr-2"></i><span key="t-dashboards">Agencies</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/lgus" id="topnav-dashboard" role="button">
                            <i class="bx bx-news mr-2"></i><span key="t-dashboards">Local Government Unit's</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/staffs" id="topnav-dashboard" role="button">
                            <i class="bx bxs-user-circle mr-2"></i><span key="t-dashboards">Staffs</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/lists" id="topnav-dashboard" role="button">
                            <i class='bx bxs-cog mr-2'></i></i><span key="t-dashboards">Lists</span> 
                        </a>
                    </li>
                    @elseif(Auth::user()->type == 'Member')
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/stations"  id="topnav-dashboard" role="button">
                            <i class='bx bx-map mr-2'></i><span key="t-dashboards">Stations</span> 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/assetlists" id="topnav-dashboard" role="button">
                            <i class="bx bx-customize mr-2"></i><span key="t-dashboards">Assets</span> 
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="/devices" id="topnav-dashboard" role="button">
                            <i class='bx bx-chip mr-2'></i><span key="t-devices">Devices</span> 
                        </a>
                    </li>
                </ul>
                  
            </div>
        </nav>
    </div>
</div>