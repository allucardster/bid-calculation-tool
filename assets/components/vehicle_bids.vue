<template>
  <h1>Vehicle Bids</h1>
  <div>
    <vehicle-bids-form @formSubmitted="handleFormSubmission"></vehicle-bids-form>
    <vehicle-bids-table :vehicleBids="vehicleBids"></vehicle-bids-table>
  </div>
</template>

<script>
import VehicleBidsForm from "./vehicle_bids_form";
import VehicleBidsTable from "./vehicle_bids_table"
import axios from "axios";

export default {
  name: 'VehicleBids',
  components: {
    VehicleBidsForm,
    VehicleBidsTable,
  },
  data() {
    return {
      vehicleBids: []
    };
  },
  methods: {
    async handleFormSubmission(formData) {
      try {
        const response = await axios.post('/api/vehicle_bids', formData);
        this.vehicleBids.push(response.data);
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>