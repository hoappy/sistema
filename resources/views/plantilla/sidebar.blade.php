<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i> Escritorio</a>
                    </li>
                    <li class="nav-title">
                        Mantenimiento
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Empresa</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Datos Empresa</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Caja de Compensacion</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Mutual</a>
                            </li>
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Representante Empresa</a>
                            </li>
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Sucursal Empresa</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Contrato</a>
                    </li>
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Trabajador</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Datos Trabajador</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> AFP</a>
                            </li>
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> salud</a>
                            </li>
                            <li @click="menu=10" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Cargas</a>
                            </li>
                            <li @click="menu=11" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Licencia</a>
                            </li>
                            <li @click="menu=12" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Finiquito</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=13" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-wallet"></i> Liquidacion</a>
                    </li>
                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Datos Liquidacion</a>
                        <ul class="nav-dropdown-items">
                        <li @click="menu=18" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Tabla de Valores</a>
                            </li>

                            <li @click="menu=14" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Descuentos</a>
                            </li>
                            
                            <li @click="menu=15" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i> Haberes</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li @click="menu=16" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>
                    <li @click="menu=17" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>