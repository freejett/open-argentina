@extends('frontend._layout.master')

@section('metaTitle', 'Главная')

@section('content')
    <div class="home-lager-shearch" style="background-color: rgb(252, 252, 252); padding-top: 25px; margin-top: -125px;">
        <div class="container">
            <div class="col-md-12 large-search">
                <div class="search-form wow pulse">
                    <form action="" class=" form-inline">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Key word">
                            </div>
                            <div class="col-md-4">
                                <select id="lunchBegins" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select your city">
                                    <option>New york, CA</option>
                                    <option>Paris</option>
                                    <option>Casablanca</option>
                                    <option>Tokyo</option>
                                    <option>Marraekch</option>
                                    <option>kyoto , shibua</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select id="basic" class="selectpicker show-tick form-control">
                                    <option> -Status- </option>
                                    <option>Rent </option>
                                    <option>Boy</option>
                                    <option>used</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="search-row">
                                <div class="col-sm-3">
                                    <label for="price-range">Price range ($):</label>
                                    <input type="text" class="span2" value="" data-slider-min="0"
                                           data-slider-max="600" data-slider-step="5"
                                           data-slider-value="[0,450]" id="price-range" ><br />
                                    <b class="pull-left color">2000$</b>
                                    <b class="pull-right color">100000$</b>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <label for="property-geo">Property geo (m2) :</label>
                                    <input type="text" class="span2" value="" data-slider-min="0"
                                           data-slider-max="600" data-slider-step="5"
                                           data-slider-value="[50,450]" id="property-geo" ><br />
                                    <b class="pull-left color">40m</b>
                                    <b class="pull-right color">12000m</b>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <label for="price-range">Min baths :</label>
                                    <input type="text" class="span2" value="" data-slider-min="0"
                                           data-slider-max="600" data-slider-step="5"
                                           data-slider-value="[250,450]" id="min-baths" ><br />
                                    <b class="pull-left color">1</b>
                                    <b class="pull-right color">120</b>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <label for="property-geo">Min bed :</label>
                                    <input type="text" class="span2" value="" data-slider-min="0"
                                           data-slider-max="600" data-slider-step="5"
                                           data-slider-value="[250,450]" id="min-bed" ><br />
                                    <b class="pull-left color">1</b>
                                    <b class="pull-right color">120</b>
                                </div>
                                <!-- End of  -->

                            </div>

                            <div class="search-row">

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Fire Place(3100)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Dual Sinks(500)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Hurricane Shutters(99)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Swimming Pool(1190)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> 2 Stories(4600)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Emergency Exit(200)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Laundry Room(10073)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Jog Path(1503)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->

                                <div class="col-sm-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> 26' Ceilings(1200)
                                        </label>
                                    </div>
                                </div>
                                <!-- End of  -->
                            </div>
                        </div>
                        <div class="center">
                            <input type="submit" value="" class="btn btn-default btn-lg-sheach">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
