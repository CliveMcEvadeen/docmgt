@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Arrival/Departure Daily Report</h2>

  <form id="entryForm" method="POST" action="{{ route('officer.submit_report') }}">
    @csrf

    <div class="mb-3">
      <label for="entry_date" class="form-label">Date</label>
      <input type="date" class="form-control" id="entry_date" name="entry_date" required>
    </div>

    <div class="mb-3">
      <label for="officer_name" class="form-label">Officer Name</label>
      <input type="text" class="form-control" id="officer_name" name="officer_name" value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}" readonly>
    </div>

    <div class="mb-3">
      <label for="location" class="form-label">Location</label>
      <input type="text" class="form-control" id="location" name="location" value="{{ $locations->first()->name ?? '' }}" readonly>
    </div>

    <div class="mb-3">
      <label for="entry_type" class="form-label">Entry Type</label>
      <select class="form-select" id="entry_type" name="entry_type" required>
        <option value="">Select</option>
        <option value="arrival">Arrival</option>
        <option value="departure">Departure</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="total_count" class="form-label">Total People (All Categories)</label>
      <input type="number" class="form-control" id="total_count" name="total_count" required>
    </div>

    <div class="section mb-3">
      <h3>Gender Breakdown</h3>
      <div class="row g-3 align-items-center">
        <div class="col-auto">
          <label for="gender_male" class="col-form-label">Male</label>
          <input type="number" class="form-control" id="gender_male" name="male_count" oninput="updateGenderTotal()">
        </div>
        <div class="col-auto">
          <label for="gender_female" class="col-form-label">Female</label>
          <input type="number" class="form-control" id="gender_female" name="female_count" oninput="updateGenderTotal()">
        </div>
        <div class="col-auto">
          <label for="gender_total" class="col-form-label">Total</label>
          <input type="number" class="form-control" id="gender_total" readonly>
        </div>
      </div>
    </div>

    <div class="section mb-3">
      <h3>Categories Breakdown</h3>
      <table class="table table-bordered">
        <thead>
          <tr><th>Category</th><th>Male</th><th>Female</th><th>Total</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Asylum Seekers</td>
            <td><input type="number" class="form-control" id="asylum_male" name="asylum_male" oninput="updateCategoryTotal('asylum')"></td>
            <td><input type="number" class="form-control" id="asylum_female" name="asylum_female" oninput="updateCategoryTotal('asylum')"></td>
            <td><input type="number" class="form-control" id="asylum_total" readonly></td>
          </tr>
          <tr>
            <td>Deportations</td>
            <td><input type="number" class="form-control" id="deport_male" name="deport_male" oninput="updateCategoryTotal('deport')"></td>
            <td><input type="number" class="form-control" id="deport_female" name="deport_female" oninput="updateCategoryTotal('deport')"></td>
            <td><input type="number" class="form-control" id="deport_total" readonly></td>
          </tr>
          <tr>
            <td>Returnees</td>
            <td><input type="number" class="form-control" id="return_male" name="return_male" oninput="updateCategoryTotal('return')"></td>
            <td><input type="number" class="form-control" id="return_female" name="return_female" oninput="updateCategoryTotal('return')"></td>
            <td><input type="number" class="form-control" id="return_total" readonly></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="section mb-3">
      <h3>Nationalities (Add Rows Manually)</h3>
      <table id="nationalityTable" class="table table-bordered">
        <thead>
          <tr><th>Nationality</th><th>Male</th><th>Female</th><th>Total</th><th>Remove</th></tr>
        </thead>
        <tbody></tbody>
      </table>
      <button type="button" class="btn btn-secondary" onclick="addNationalityRow()">Add Nationality</button>
    </div>

    <div class="section mb-3">
      <h3>Transport Details</h3>
      <label for="mode" class="form-label">Mode of Transport</label>
      <select class="form-select" id="mode" name="mode" onchange="toggleTransportDetails(this.value)">
        <option value="">Select</option>
        <option value="flight">Flight</option>
        <option value="land">Land</option>
        <option value="marine">Marine</option>
      </select>

      <div id="flightDetails" style="display: none;">
        <h4>Flight Entries</h4>
        <table id="flightTable" class="table table-bordered">
          <thead>
            <tr><th>Flight Number</th><th>Origin</th><th>Destination</th><th>Remove</th></tr>
          </thead>
          <tbody></tbody>
        </table>
        <button type="button" class="btn btn-secondary" onclick="addFlightRow()">Add Flight</button>
      </div>
    </div>

    <div class="mb-3">
      <label for="comments" class="form-label">Any Additional Comments</label>
      <textarea id="comments" name="comments" rows="4" class="form-control" placeholder="Write any observations or notes here..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<script>
function updateGenderTotal() {
  const male = parseInt(document.getElementById('gender_male').value) || 0;
  const female = parseInt(document.getElementById('gender_female').value) || 0;
  document.getElementById('gender_total').value = male + female;
}
function updateCategoryTotal(prefix) {
  const male = parseInt(document.getElementById(prefix + '_male').value) || 0;
  const female = parseInt(document.getElementById(prefix + '_female').value) || 0;
  document.getElementById(prefix + '_total').value = male + female;
}
function addNationalityRow() {
  const table = document.getElementById('nationalityTable').getElementsByTagName('tbody')[0];
  const row = table.insertRow();
  const nationality = row.insertCell(0);
  const male = row.insertCell(1);
  const female = row.insertCell(2);
  const total = row.insertCell(3);
  const remove = row.insertCell(4);

  nationality.innerHTML = '<input type="text" name="nationality[]">';
  male.innerHTML = '<input type="number" name="nationality_male[]" oninput="updateRowTotal(this)" class="form-control">';
  female.innerHTML = '<input type="number" name="nationality_female[]" oninput="updateRowTotal(this)" class="form-control">';
  total.innerHTML = '<input type="number" readonly class="form-control">';
  remove.innerHTML = '<button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">X</button>';
}
function updateRowTotal(elem) {
  const row = elem.parentElement.parentElement;
  const male = parseInt(row.cells[1].children[0].value) || 0;
  const female = parseInt(row.cells[2].children[0].value) || 0;
  row.cells[3].children[0].value = male + female;
}
function toggleTransportDetails(value) {
  document.getElementById('flightDetails').style.display = (value === 'flight') ? 'block' : 'none';
}
function addFlightRow() {
  const table = document.getElementById('flightTable').getElementsByTagName('tbody')[0];
  const row = table.insertRow();
  row.innerHTML = `
    <td><input type="text" name="flight_number[]" class="form-control"></td>
    <td><input type="text" name="origin[]" class="form-control"></td>
    <td><input type="text" name="destination[]" class="form-control"></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">X</button></td>
  `;
}
</script>
@endsection
