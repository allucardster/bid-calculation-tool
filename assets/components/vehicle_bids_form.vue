<template>
  <nav class="navbar">
    <div class="container-fluid">
      <form class="d-flex" @submit.prevent="submitForm">
        <div class="input-group me-2">
          <label for="vehiclePrice" class="navbar-text me-2">Vehicle Price</label>
          <input type="number" class="form-control" id="vehiclePrice" v-model.number="formData.vehiclePrice">
        </div>
        <div class="input-group me-2">
          <label for="vehicleType" class="navbar-text me-2">Vehicle Type</label>
          <select id="vehicleType" class="form-select" v-model="formData.vehicleType">
            <option v-for="vehicleType in vehicleTypes" :value="vehicleType.value">
              {{ vehicleType.text }}
            </option>
          </select>
        </div>
        <button class="btn btn-primary" type="submit" :disabled="isFormInvalid">Calculate</button>
      </form>
    </div>
  </nav>
</template>
<script>

import {ref} from "vue";

export default {
  name: 'VehicleBidsForm',
  data() {
    return {
      vehicleTypes: ref([
        { text: 'Common', value: 'common' },
        { text: 'Luxury', value: 'luxury' },
      ]),
      formData: {
        vehiclePrice: 0,
        vehicleType: ref('common')
      }
    }
  },
  computed: {
    // Computed property to check if the form fields are valid
    isFormInvalid() {
      return this.formData.vehiclePrice <= 0 || !this.formData.vehiclePrice || !this.formData.vehicleType;
    }
  },
  methods: {
    submitForm() {
      // Emit the form data to the parent component
      this.$emit('formSubmitted', this.formData);
    }
  }
}
</script>
