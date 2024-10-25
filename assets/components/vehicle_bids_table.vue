<template>
  <table class="table table-striped table-bordered">
    <thead>
      <tr class="align-middle">
        <th rowspan="2">Vehicle Price ($)</th>
        <th rowspan="2">Vehicle Type</th>
        <th colspan="4">Fees ($)</th>
        <th rowspan="2">Total ($)</th>
      </tr>
      <tr>
        <th>Basic</th>
        <th>Special</th>
        <th>Association</th>
        <th>Storage</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="vehicleBid in vehicleBids">
        <td>{{formatCurrency(vehicleBid.vehicle.price)}}</td>
        <td>{{vehicleBid.vehicle.type}}</td>
        <td v-for="fee in vehicleBid.fees">{{formatCurrency(fee.value)}}</td>
        <td>{{formatCurrency(vehicleBid.total)}}</td>
      </tr>
    </tbody>
  </table>
</template>
<script>
export default {
  name: 'VehicleBidsTable',
  props: {
    vehicleBids: {
      type: Array,
      default: []
    }
  },
  methods: {
    formatCurrency: (value) => (Math.round(value * 100) / 100).toFixed(2)
  }
}
</script>
<style>

</style>
