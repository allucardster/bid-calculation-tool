<template>
  <nav class="navbar fixed-top bg-dark border-bottom border-body navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Bid Calculation Tool</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/api" target="_blank">Api Docs</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <vehicle-bids></vehicle-bids>
</template>
<script>
import VehicleBids from "../components/vehicle_bids";

export default {
  name: 'App',
  components: {
    VehicleBids,
  }
};
</script>