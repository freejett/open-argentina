<div class="panel panel-default sidebar-menu wow fadeInRight animated" >
    <div class="panel-heading">
        <h3 class="panel-title">Подбор по параметрам:</h3>
    </div>
    <div class="panel-body search-widget">
        <form method="GET" action="{{ route('front.aparts.index') }}" class=" form-inline">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <label for="price-range">Количество комнат:</label>
                        <select name="number_of_rooms" id="lunchBegins" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Количество комнат">
                            @foreach ($apartTypes as $apartTypeId => $apartTypeTitle)
                                <option value="{{ $apartTypeId }}" @if(isset($filter['number_of_rooms']) && $apartTypeId == $filter['number_of_rooms']) selected @endif>
                                    {{ $apartTypeTitle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset class="padding-5">
                <div class="row">
                    <div class="col-xs-12">
                        <label for="price-range">Стоимость (USD):</label>
                        <input name="price" type="text" class="span2" value="{{ $min .','. $max}}" data-slider-min="0"
                               data-slider-max="5000" data-slider-step="50"
                               data-slider-value="[{{ $min .','. $max}}]" id="price-range" ><br />
                        <b class="pull-left color">0 USD</b>
                        <b class="pull-right color">5000 USD</b>
                    </div>
                </div>
            </fieldset>

            <fieldset class="padding-5">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <label>
                                <input name="kids_allowed" type="checkbox" @checked(old('kids_allowed', $filter['kids_allowed'] ?? null)) /> можно с детьми
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input name="pets_allowed" type="checkbox" @checked(old('pets_allowed', $filter['pets_allowed'] ?? null)) /> можно с животными
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset >
                <div class="row">
                    <div class="col-xs-12">
                        <input class="button btn largesearch-btn" value="Поиск" type="submit">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

