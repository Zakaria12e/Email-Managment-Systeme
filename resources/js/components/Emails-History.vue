<template>
    <div>
      <div style="margin-top: -10px;" class="flex-1 pr-8">
        <div class="bg-white p-4 rounded shadow-md">
          <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Emails Envoyés</h1>
            <div class="flex items-center space-x-2 md:space-x-4">
              <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
                <span class="sr-only">Search</span>
              </button>
              <div class="relative hidden md:block">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                  </svg>
                  <span class="sr-only">Search icon</span>
                </div>
                <input type="text" v-model="searchQuery" id="search-navbar" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-gray-500" placeholder="Par Sujet...">
              </div>
            </div>
          </div>
          <div v-if="filteredEmails.length === 0" class="text-gray-600">Aucun email disponible pour le moment.</div>
          <div class=" p-4 rounded-md shadow-sm" v-else>
  <div class="w-full bg-white border rounded-lg p-4">
    <div v-for="email in paginatedEmails" :key="email.id" @click="goToEmailDetail(email.id)" class="w-full bg-gray-100 border rounded-lg  px-4 py-2 mb-4  hover:bg-gray-200 transition duration-200 cursor-pointer">
      <div class="flex justify-between items-center">
        <div class="text-lg font-medium">Sujet : {{ email.sujet }}</div>
        <div class="text-gray-500">{{ new Date(email.created_at).toLocaleDateString() }}</div>
      </div>
      <div class="text-gray-600" v-html="truncateAndRenderHTML(email.contenu)"></div>
    </div>
  </div>
</div>

          <div class="flex justify-between items-center mt-4">
            <a v-if="currentPage > 1" @click.prevent="prevPage"    class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer">
              <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
              </svg>
              Précédent
            </a>
            <a v-if="currentPage < totalPages" @click.prevent="nextPage"    class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray bg-gray-50 border border-gray-400 rounded-lg hover:bg-gray-100 hover:border-gray-500 hover:cursor-pointer">
              Suivant
              <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <Spiner v-if="loading" />
    </div>
  </template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Spiner from '@/components/Spiner.vue';

const emails = ref([]);
const searchQuery = ref('');
const currentPage = ref(1);
const emailsPerPage = 5;
const router = useRouter();
const loading = ref(false);

const filteredEmails = computed(() => {
  return emails.value.filter(email => email.sujet.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

const paginatedEmails = computed(() => {
  const start = (currentPage.value - 1) * emailsPerPage;
  return filteredEmails.value.slice(start, start + emailsPerPage);
});

const totalPages = computed(() => {
  return Math.ceil(filteredEmails.value.length / emailsPerPage);
});

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};
const truncateAndRenderHTML = (content) => {

  const strippedContent = content.replace(/(<([^>]+)>)/gi, '');

  const words = strippedContent.split(' ');

  const truncatedContent = words.slice(0, 10).join(' ');

  return `${truncatedContent}...`;
};


const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

onMounted(async () => {
  try {
    loading.value = true;
    const response = await axios.get('/api/get-emails');
    emails.value = response.data.emails;
  } catch (error) {
    console.error('Échec de la récupération des emails :', error);
  } finally {
    loading.value = false;
  }
});

const goToEmailDetail = (emailId) => {
  router.push(`/admin/emails-History/${emailId}`);
};

</script>
