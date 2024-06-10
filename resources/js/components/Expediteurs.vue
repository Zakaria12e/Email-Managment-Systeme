<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import axios from 'axios';
import * as XLSX from 'xlsx';

const expediteurs = ref([]);

const fetchExpediteurs = async () => {
  try {
    const response = await axios.get('/api/get-expediteurs');
    expediteurs.value = response.data.Expediteurs;
  } catch (error) {
    console.error('Error fetching expediteurs:', error);
  }
};

onMounted(() => {
  fetchExpediteurs();
});

const searchQuery = ref('');

const filteredExpediteurs = computed(() => {
  return expediteurs.value.filter(expediteur => {
    return (
      (expediteur.exped_nom && expediteur.exped_nom.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (expediteur.email_exped && expediteur.email_exped.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (expediteur.exped_phone && expediteur.exped_phone.toLowerCase().includes(searchQuery.value.toLowerCase())) ||
      (expediteur.exped_org && expediteur.exped_org.toLowerCase().includes(searchQuery.value.toLowerCase()))
    );
  });
});


const itemsPerPage = 6;
const currentPage = ref(1);

const calculatePagination = () => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  return { startIndex, endIndex };
};

const getPaginatedExpediteurs = () => {
  const { startIndex, endIndex } = calculatePagination();
  return filteredExpediteurs.value.slice(startIndex, endIndex);
};

const paginatedExpediteurs = computed(getPaginatedExpediteurs);

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

const totalPages = computed(() => Math.ceil(filteredExpediteurs.value.length / itemsPerPage));

watch(searchQuery, () => {
  currentPage.value = 1;
});



const exportToExcel = () => {
  const data = filteredExpediteurs.value.map(expediteur => ({
    Nom: expediteur.exped_nom,
    Email: expediteur.email_exped,
    Telephone: expediteur.exped_phone,
    Organisation: expediteur.exped_org,
  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Expediteurs");

  XLSX.writeFile(workbook, "expediteurs.xlsx");
};
</script>

<template>

  <nav style="margin-bottom: 100px;"  class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center text-blue-500">
          <a href="#" class="text-gray-700">Home</a>
          <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
        </li>
        <li class="flex items-center">
          <p class="text-gray-600">Expediteurs</p>
        </li>
      </ol>
    </nav>

  <div class="mx-auto max-w-screen-xl mt-12 px-4 lg:px-12">
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
              <input v-model="searchQuery" type="text" id="role-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Chercher...">
            </div>
          </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
          <button @click="exportToExcel" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Exporter
          </button>

        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-4 text-center">Nom</th>
              <th scope="col" class="px-4 py-3 text-center">Email</th>
              <th scope="col" class="px-4 py-3 text-center">Telephone</th>
              <th scope="col" class="px-4 py-3 text-center">Organisation</th>
            </tr>
          </thead>
          <tbody v-if="paginatedExpediteurs.length > 0">
            <tr v-for="expediteur in paginatedExpediteurs" :key="expediteur.id" class="border-b dark:border-gray-700">
              <td class="px-4 py-3 text-center">{{ expediteur.exped_nom }}</td>
              <td class="px-4 py-3 text-center">{{ expediteur.email_exped }}</td>
              <td class="px-4 py-3 text-center">{{ expediteur.exped_phone }}</td>
              <td class="px-4 py-3 text-center">{{ expediteur.exped_org }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <nav class="justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        <div class="flex justify-between items-center mt-4">
          <a v-if="currentPage > 1" @click.prevent="prevPage" class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer">
            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
            </svg>
            Précédent
          </a>
          <a v-if="currentPage < totalPages" @click.prevent="nextPage" class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer">
            Suivant
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
          </a>
        </div>
      </nav>
    </div>
  </div>
</template>
