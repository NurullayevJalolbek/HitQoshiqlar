<form class="row g-2" id="filter-form">

    <div class="col-12 col-md-4">
        <input type="text" id="filter_search" class="form-control"
               placeholder="Qidirish (F.I.O, login, telefon)">
    </div>

    <div class="col-12 col-md-3">
        <select id="filter_status" class="form-control">
            <option value="">Status</option>
            <option value="active">Active</option>
            <option value="blocked">Blocked</option>
        </select>
    </div>

    <div class="col-12 col-md-3">
        <button type="button" id="filterBtn" class="btn btn-primary w-100">Filter</button>
    </div>

</form>
