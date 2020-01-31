
            <div class="row">
                <div class="col-lg-3">
                <a href="{{route('students.index')}}">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2>Students</h2>
                                <div class="main-income-phara">
                                    <p>View</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">
                                       {{App\Models\Student::count()}}
                                        </span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline1"></span>
                                </div>
                            </div>
                            <div class="income-range">
                                <p>Registered Students</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('subjects.index')}}">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2>Subjects</h2>
                                <div class="main-income-phara order-cl">
                                    <p>View</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">
                                        {{App\Subject::count()}}
                                        </span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline6"></span>
                                </div>
                            </div>
                            <div class="income-range order-cl">
                                <p>Both O & A-Level Subjects</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                        </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('teachers.index')}}">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2>Teachers</h2>
                                <div class="main-income-phara low-value-cl">
                                    <p>View</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">
                                        {{App\Role::whereName('teacher')->first()->users()->count()}}
                                        </span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline5"></span>
                                </div>
                            </div>
                            <div class="income-range low-value-cl">
                                <p>Total teachers</p></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="{{route('classes.index')}}">
                    <div class="income-dashone-total shadow-reset nt-mg-b-30">
                        <div class="income-title">
                            <div class="main-income-head">
                                <h2>Classes</h2>
                                <div class="main-income-phara visitor-cl">
                                    <p>View</p>
                                </div>
                            </div>
                        </div>
                        <div class="income-dashone-pro">
                            <div class="income-rate-total">
                                <div class="price-adminpro-rate">
                                    <h3><span class="counter">
                                        {{App\Schclass::count()}}
                                        </span></h3>
                                </div>
                                <div class="price-graph">
                                    <span id="sparkline2"></span>
                                </div>
                            </div>
                            <div class="income-range visitor-cl">
                                <p>Total Created</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>

