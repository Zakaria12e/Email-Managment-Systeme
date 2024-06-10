<script setup>
  import { ref , onMounted } from 'vue';
  import axios from 'axios';
  import { useToastr } from '@/toastr';

  const firstName = ref('');
  const lastName = ref('');
  const StructureId = ref('');
  const phone = ref('');
  const selectedRoles = ref([]);
  const departmentId = ref('');
  const email1 = ref('');
  const email2 = ref('');
  const toastr = useToastr();
  const departments = ref([]);
  const roles = ref([]);


const fetchDepartments = async () => {
  try {
    const response = await axios.get('/api/getdepartments');
    departments.value = response.data;
  } catch (error) {
    console.error('Error fetching departments:', error);
  }
};
const fetchRoles = async () => {
  try {
    const response = await axios.get('/api/getroles');
    roles.value = response.data;
  } catch (error) {
    console.error('Error fetching roles:', error);
  }
};


onMounted(() => {
    fetchDepartments();
    fetchRoles();
  });


  const validateForm = () => {
    if (!firstName.value || !lastName.value || !phone.value || !email1.value) {
      toastr.error('Veuillez remplir tous les champs requis');
      return false;
    }
    return true;
  }

  const checkUniqueFields = async () => {
    try {
      const response = await axios.post('/api/check-unique-fields', {
        email1: email1.value,
        email2: email2.value,
        phone: phone.value,
      });
      const data = response.data;
      if (!data.email1Unique) {
        toastr.error('L\'adresse e-mail 1 existe déjà');
        return false;
      }
      if (!data.email2Unique) {
        toastr.error('L\'adresse e-mail 2 existe déjà');
        return false;
      }
      if (!data.phoneUnique) {
        toastr.error('Le numéro de téléphone existe déjà');
        return false;
      }
      return true;
    } catch (error) {
      console.error(error);
      return false;
    }
  }

  const submitForm = async () => {
    if (!validateForm()) {
      return;
    }
    if (!await checkUniqueFields()) {
      return;
    }
    try {
      const response = await axios.post('/api/create-reception', {
        first_name: firstName.value,
        last_name: lastName.value,
        structurId: StructureId.value,
        phone: phone.value,
        roles: selectedRoles.value,
        departmentId: departmentId.value,
        email1: email1.value,
        email2: email2.value,
      });

      toastr.success('Le destinataire a été créé avec succès!');


      firstName.value = '';
      lastName.value = '';
      StructureId.value = '';
      phone.value = '';
      selectedRoles.value = [];
      departmentId.value = '';
      email1.value = '';
      email2.value = '';
    } catch (error) {
      console.error(error);
    }
  }


const dropdownOpen = ref(false);

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};
</script>


<template>





    <nav class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center text-blue-500">
          <a href="#" class="text-gray-700">Home</a>
          <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
        </li>
        <li class="flex items-center">
          <p href="#" class="text-gray-600">Créer des Destinataires</p>
        </li>
      </ol>
    </nav>


    <div class="flex justify-center">
          <form style="width: 55%;" @submit.prevent="submitForm">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">Prénom</label>
                    <input type="text" v-model="firstName" id="first_name" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"   />
                </div>
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                    <input type="text" v-model="lastName" id="last_name" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"   />
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium text-gray-900">Structure</label>
                    <input type="text" v-model="StructureId" id="company" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"   />
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Numéro de téléphone</label>
                    <input type="tel" v-model="phone" id="phone" pattern="[0-9]*" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
 </div>


  <div>
    <label for="Type-destinataire" class="block mb-2 text-sm font-medium text-gray-900">Type de destinataire</label>
    <div class="relative">
        <button type="button" @click="toggleDropdown" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-left">
            {{ dropdownOpen ? 'Cliquez ici pour fermer' : 'Cliquez ici pour ouvrir' }}
        </button>
        <div v-if="dropdownOpen" class="absolute z-10 bg-white border border-gray-400 text-gray-900 text-sm rounded-lg w-full mt-1">
            <div v-for="role in roles" :key="role.id" class="p-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" :value="role.id" v-model="selectedRoles" class="form-checkbox">
                    <span class="ml-2">{{ role.name }}</span>
                </label>
            </div>
        </div>
    </div>
</div>
                <div>
                    <label for="departments" class="block mb-2 text-sm font-medium text-gray-900">Département</label>
                    <select v-model="departmentId"  id="departments" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                      <option value="" disabled selected>Choisir un département</option>
                      <option v-for="department in departments" :key="department.id" :value="department.id">{{ department.dept_name }}</option>
                    </select>
                  </div>

            </div>
            <div class="mb-6">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Adresse e-mail 1</label>
                <input type="email" v-model="email1" id="email1" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"   />
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Adresse e-mail 2</label>
                <input type="email" v-model="email2" id="email2" class="bg-gray-50 border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>

            <button type="submit" class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Soumettre</button>

          </form>
        </div>



</template>
 <style scoped>
 .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-toggle {
 width: 457px;
  cursor: pointer;

}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  background-color: #fff;
  border: 1px solid #ced4da;
  padding: 0.5rem;
}

.checkbox {
  display: block;
}
</style>

