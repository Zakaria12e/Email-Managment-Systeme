<script setup>

import { ref , onMounted , computed, watch} from 'vue';
import axios from 'axios';
import { useToastr } from '@/toastr';

const formData = ref({
  dept_name: '',
  chef_dept: '',
  description: ''
});
const toastr = useToastr();
const isModalOpen = ref(false);

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};



const validateForm = () => {
  if (!formData.value.dept_name || !formData.value.description) {
    toastr.error('Veuillez remplir tous les champs requis');
    return false;
  }
  return true;
};

const createDepartment = () => {
  if (!validateForm()) {
    return;
  }
  axios.post('/api/create-departments', formData.value)
    .then(response => {
      toastr.success('Département créé avec succès!');
      closeModal();
      fetchDepartments();

      formData.value.dept_name = '';
      formData.value.chef_dept = '';
      formData.value.description = '';
    })
    .catch(error => {
      console.error('Erreur lors de la création du département:', error);
    });
};

const departments = ref([]);

const fetchDepartments = async () => {
  try {
    const response = await axios.get('/api/getdepartments');
    departments.value = response.data;
  } catch (error) {
    console.error('Error fetching departments:', error);
  }
};

onMounted(() => {
    fetchDepartments();
});

const searchQuery = ref('');


const filteredDepartments = computed(() => {
  return departments.value.filter(department => {
    return (
      department.dept_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      department.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
});

const itemsPerPage = 4;
let currentPage = ref(1);

const calculatePagination = () => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return { startIndex, endIndex };
};

const getPaginatedDepartments = () => {
  const { startIndex, endIndex } = calculatePagination();
  return filteredDepartments.value.slice(startIndex, endIndex);
};

const paginatedDepartments = computed(getPaginatedDepartments);

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const totalPages = computed(() => Math.ceil(filteredDepartments.value.length / itemsPerPage));



watch(searchQuery, () => {
  currentPage.value = 1;
});

</script>


<template>


    <nav style="margin-bottom: 100px;" class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center text-blue-500">
          <a href="#" class="text-gray-700">Home</a>
          <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
        </li>
        <li class="flex items-center">
          <p href="#" class="text-gray-600">Départements</p>
        </li>
      </ol>
    </nav>


    <div v-if="isModalOpen" id="crud-modal" tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 ">
        <div class="relative p-4 w-full max-w-md max-h-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Ajouter Département
                    </h3>
                    <button @click="closeModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="createDepartment" class="p-4 md:p-5">
                    <div class="col-span-2 mb-3">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                        <input v-model="formData.dept_name" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Entrez le nom de département">
                    </div>
                    <div class="col-span-2 sm:col-span-1 mb-3">
                        <label for="chef" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Chef</label>
                        <input v-model="formData.chef_dept" type="text" name="chef" id="chef" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>

                    <div class="col-span-2 mb-3">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea v-model="formData.description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Écrivez la description de département ici"></textarea>
                    </div>

                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>








    <div class="mx-auto max-w-screen-xl mt-6 px-4 lg:px-12">

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full md:w-auto">
    <label for="role-search" class="sr-only">Search</label>
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
      </svg>
    </div>
    <input v-model="searchQuery" type="text" id="role-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nom du département...">
  </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">

                    <button
          @click="openModal"
            class="inline-block px-4 py-2 text-white duration-150 font-medium bg-blue-400 rounded-lg hover:bg-blue-500 active:bg-indigo-700 md:text-sm"
            >Ajouter Département
        </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                        <th scope="col" class="px-4 py-4 text-center">Nom</th>
                        <th scope="col" class="px-4 py-4 text-center">Description</th>
                        <th scope="col" class="px-4 py-4 text-center">Chef</th>
                        <th scope="col" class="px-4 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody  v-if="paginatedDepartments.length > 0">
                        <tr v-for="department in paginatedDepartments" :key="department.id" class="border-b dark:border-gray-700">
                                <td class="px-4 py-3  text-center">{{ department.dept_name }}</td>
                                <td class="px-4 py-3  text-center ">{{ department.description }}</td>
                                <td class="px-4 py-3  text-center ">{{ department.chef_dept }}</td>


                                <td class="relative px-4 py-3 text-center">
    <button  class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
      <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
      </svg>
    </button>
  </td>
                        </tr>



                    </tbody>
                </table>
            </div>
            <nav class=" justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">

                <div class="flex justify-between items-center mt-4">
            <a
            v-if="currentPage > 1"
              @click.prevent="prevPage"
              class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer"
            >
              <svg
                class="w-3.5 h-3.5 me-2 rtl:rotate-180"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 10"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 5H1m0 0 4 4M1 5l4-4"
                />
              </svg>
              Précédent
            </a>
            <a
            v-if="currentPage < totalPages"
              @click.prevent="nextPage"
              class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer"
            >
              Suivant
              <svg
                class="w-3.5 h-3.5 ms-2 rtl:rotate-180"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 10"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M1 5h12m0 0L9 1m4 4L9 9"
                />
              </svg>
            </a>
          </div>
            </nav>
        </div>
    </div>


</template>

