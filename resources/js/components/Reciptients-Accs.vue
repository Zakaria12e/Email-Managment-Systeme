<template>

  <header class="mb-6">
        <h1 class="text-3xl font-bold"></h1>
    </header>
    <nav class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center text-blue-500">
          <a href="#" class="text-gray-700">Home</a>
          <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
        </li>
        <li class="flex items-center">
          <p class="text-gray-600">Destinataire</p>
        </li>
      </ol>
    </nav>

    <div class="mx-auto max-w-screen-xl mt-6 px-4 lg:px-12">
 <div
        v-if="selectedDestinataire"
        id="updateDestinataireModal"
        tabindex="-1"
        aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50"
      >
      <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
  <!-- Contenu du modal -->
  <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
    <!-- En-tête du modal -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        Mettre à jour le Destinataire
      </h3>
      <button
        type="button"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
        @click="closeModal"
      >
        <svg
          aria-hidden="true"
          class="w-5 h-5"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clip-rule="evenodd"
          />
        </svg>
        <span class="sr-only">Fermer le modal</span>
      </button>
    </div>
    <!-- Corps du modal -->
    <form @submit.prevent="updateDestinataire">
      <div class="grid gap-4 mb-4 sm:grid-cols-2">
        <div>
          <label for="nom_prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Nom
          </label>
          <input
            type="text"
            v-model="selectedDestinataire.nom"
            id="nom_prenom"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
          />
        </div>
        <div>
          <label for="nom_prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Prénom
          </label>
          <input
            type="text"
            v-model="selectedDestinataire.prenom"
            id="nom_prenom"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
          />
        </div>
        <div>
          <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Téléphone
          </label>
          <input
            type="text"
            v-model="selectedDestinataire.telephone"
            id="telephone"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
          />
        </div>

        <div>
          <label for="nom_prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Email 1
          </label>
          <input
            type="text"
            v-model="selectedDestinataire.email1"
            id="nom_prenom"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
          />
        </div> <div>
          <label for="nom_prenom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
           Email 2
          </label>
          <input
            type="text"
            v-model="selectedDestinataire.email2"
            id="nom_prenom"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
          />
        </div>
        <div class="relative">
            <label for="roles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
      Rôles
    </label>
    <button type="button" @click="toggleDropdown" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
      {{ dropdownOpen ? 'Cliquez ici pour fermer les rôles' : 'Cliquez ici pour ouvrir les rôles' }}
    </button>
    <div v-if="dropdownOpen" class="absolute z-10 bg-white border border-gray-400 text-gray-900 text-sm rounded-lg w-full mt-1">
      <div v-for="role in roles" :key="role.id" class="p-2">
        <label class="inline-flex items-center">
          <input type="checkbox" :value="role.id" v-model="selectedDestinataire.roles" class="form-checkbox">
          <span class="ml-2">{{ role.name }}</span>
        </label>
      </div>
    </div>

          </div>
      </div>
      <div class="flex items-center space-x-4">
        <button
          type="submit"
          class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
        >
          Mettre à jour
        </button>
        <button
          type="button"
          class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
          @click="deleteDestinataire(selectedDestinataire.id)"
        >
          <svg
            class="mr-1 -ml-1 w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          Supprimer
        </button>
      </div>
    </form>
  </div>
</div>


      </div>
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
<input v-model="searchQuery" type="text" id="role-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="chercher...">
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
                <th scope="col" class="px-4 py-4 text-center">Nom & Prenom</th>
                <th scope="col" class="px-4 py-4 text-center">Emails</th>
                <th scope="col" class="px-4 py-4 text-center">Telephone</th>
                <th scope="col" class="px-4 py-4 text-center">Roles</th>
                <th scope="col" class="px-4 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody  v-if="paginatedDestinataires.length > 0">
                <tr v-for="destinataire in paginatedDestinataires" :key="destinataire.id" class="border-b dark:border-gray-700">
                        <td class="px-4 py-3  text-center">{{ destinataire.nom_prenom }}</td>
                        <td class="px-4 py-3  text-center ">{{ destinataire.emails }}</td>
                        <td class="px-4 py-3  text-center ">{{ destinataire.telephone}}</td>
                        <td  class="px-4 py-3  text-center">{{ destinataire.rolesNames }}</td>


                        <td class="relative px-4 py-3 text-center">
  <button @click="showModal(destinataire)" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
    </svg>
  </button>
</td>
                </tr>



            </tbody>
            <tbody v-else>
    <tr>
        <td  colspan="5" class="px-4 py-3 text-center">Aucun destinataire disponible pour le moment.</td>
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
<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Spiner from '@/components/Spiner.vue';
import * as XLSX from 'xlsx';

const destinataires = ref([]);
const searchQuery = ref('');
const roles = ref([]);
const currentPage = ref(1);
const itemsPerPage = 6;
const selectedDestinataire = ref(null);
const loading = ref(true);
const dropdownOpen = ref(false);

const fetchDestinataires = async () => {
  try {
    const response = await axios.get('/api/destinataires');
    destinataires.value = response.data;
  } catch (error) {
    console.error('Error fetching destinataires:', error);
  } finally {
    loading.value = false;
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

const filteredDestinataires = computed(() => {
  if (!searchQuery.value) {
    return destinataires.value;
  }
  return destinataires.value.filter((d) =>
    d.nom_prenom.toLowerCase().includes(searchQuery.value.toLowerCase())||
    d.email1.toLowerCase().includes(searchQuery.value.toLowerCase())||
    d.telephone.includes(searchQuery.value)
  );
});


const totalPages = computed(() => {
  return Math.ceil(filteredDestinataires.value.length / itemsPerPage);
});

const paginatedDestinataires = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return filteredDestinataires.value.slice(start, end);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value += 1;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value -= 1;
  }
};

const showModal = (destinataire) => {
  selectedDestinataire.value = { ...destinataire };
};

const closeModal = () => {
  selectedDestinataire.value = null;
};

const updateDestinataire = async () => {
  try {
    await axios.put(`/api/destinataires/${selectedDestinataire.value.id}`, selectedDestinataire.value);
    await fetchDestinataires();
    closeModal();
  } catch (error) {
    console.error('Error updating destinataire:', error);
  }
};

const deleteDestinataire = async (id) => {
  try {
    await axios.delete(`/api/destinataires/${id}`);
    await fetchDestinataires();
    closeModal();
  } catch (error) {
    console.error('Error deleting destinataire:', error);
  }
};

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};

onMounted(() => {
  fetchDestinataires();
  fetchRoles();
});

const exportToExcel = () => {
  const data = filteredDestinataires.value.map(destinataire => ({
    Nom: destinataire.nom,
    Prenom: destinataire.prenom,
    Email1: destinataire.email1,
    Email2: destinataire.email2,
    Telephone: destinataire.telephone,
    Roles: destinataire.rolesNames,

  }));

  const worksheet = XLSX.utils.json_to_sheet(data);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "Destinataires");

  XLSX.writeFile(workbook, "destinataires.xlsx");
};
</script>

