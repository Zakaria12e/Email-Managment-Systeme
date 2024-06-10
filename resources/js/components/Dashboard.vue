<template >
    <div id="home">
      <nav class="text-sm font-semibold mb-12" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
          <li class="flex items-center text-blue-500">
            <a href="#" class="text-gray-700">Home</a>
            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
          </li>
          <li class="flex items-center">
            <p href="#" class="text-gray-600">Dashboard</p>
          </li>
        </ol>
      </nav>

      <div class="lg:flex justify-between items-center mb-6">
        <p class="text-2xl font-semibold mb-4 lg:mb-0">Bonjour, {{ userName }}!</p>
      </div>

      <div  class="flex justify-center mb-20">
        <div class="w-1/2 xl:w-1/4 px-3">
          <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
            <svg class="w-16 h-16 text-emerald-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16v-5.5A3.5 3.5 0 0 0 7.5 7m3.5 9H4v-5.5A3.5 3.5 0 0 1 7.5 7m3.5 9v4M7.5 7H14m0 0V4h2.5M14 7v3m-3.5 6H20v-6a3 3 0 0 0-3-3m-2 9v4m-8-6.5h1"/>
            </svg>
            <div class="text-gray-700 pl-2">
              <p class="font-semibold text-3xl">{{ emailCount }}</p>
              <p>Emails Envoyer</p>
            </div>
          </div>
        </div>

        <div class="w-1/2 xl:w-1/4 px-3">
          <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
            <svg class="w-16 h-16 text-emerald-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            <div class="text-gray-700 pl-2">
              <p class="font-semibold text-3xl">{{ destinatairesCount }}</p>
              <p>Destinataire</p>
            </div>
          </div>
        </div>
        <div class="w-1/2 xl:w-1/4 px-3">
          <div class="w-full bg-white border text-blue-400 rounded-lg flex items-center p-6 mb-6 xl:mb-0">
            <svg class="w-16 h-16 text-emerald-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"/>
  </svg>


            <div class="text-gray-700 pl-2">
              <p class="font-semibold text-3xl">{{ expediteursCount }}</p>
              <p>Expediteurs</p>
            </div>
          </div>
        </div>
      </div>

      <div class="flex flex-wrap -mx-3">


        <div class="w-full xxl:w-1/3 px-3" v-if="lastEmailssent.length > 0">

        <p class="text-xl font-semibold mb-4">Derniers e-mails envoyés</p>
        <div class="w-full bg-white border rounded-lg p-4">
          <div v-if="lastEmailssent.length === 0" class="text-gray-600">Aucun email récent disponible.</div>
          <div v-else>
            <div v-for="email in lastEmailssent" :key="email.id" class="email-item" @click="showEmailDetails(email.id)">
              <div class="w-full bg-gray-100 border rounded-lg flex justify-between items-center px-4 py-2 mb-4">
                <div>
                  <p class="font-semibold text-xl">{{ email.sujet }}</p>
                  <p v-html="truncateAndRenderHTML(email.contenu)"></p>
                </div>
                <div>
        <span class="text-gray-500 font-semibold">{{ new Date(email.created_at).toLocaleDateString() }}</span><br>
        <span class="text-gray-500">{{ new Date(email.created_at).toLocaleTimeString() }}</span>
    </div>       </div>
            </div>
          </div>
        </div>

    </div>
      </div>
    </div>
  </template>

<script setup>
import axios from 'axios';
import { ref, onMounted, watch } from 'vue';


const lastEmailssent = ref([]);
const emailCount = ref(0);
const userName = ref('');
const destinatairesCount = ref(0);
const expediteursCount = ref(0);


const fetchDestinatairesCount = async () => {
    try {
        const response = await axios.get('/api/destinatairesCount');
        destinatairesCount.value = response.data.count;
    } catch (error) {
        console.error('Error fetching destinataires count:', error);
    }
};



const fetchExpediteurs = async () => {
  try {
    const response = await axios.get('/api/get-expediteurs');
    expediteursCount.value = response.data.count;
  } catch (error) {
    console.error('Error fetching expediteurs count:', error);
  }
};

onMounted(async () => {
    try {
        const response = await axios.get('/api/get-emails');
        const sortedEmails = response.data.emails.sort((a, b) => b.id - a.id);
        lastEmailssent.value = sortedEmails.slice(0, 3);

        emailCount.value = response.data.email_count;
        
         fetchUserName();
         fetchDestinatairesCount();
         fetchExpediteurs();

    } catch (error) {
        console.error('Erreur lors de la récupération des emails récents :', error);
    }
});


const truncateAndRenderHTML = (content) => {
    const strippedContent = content.replace(/(<([^>]+)>)/gi, '');
    const words = strippedContent.split(' ');
    const truncatedContent = words.slice(0, 10).join(' ');
    return `${truncatedContent}...`;
};

const fetchUserName = async () => {
    try {
        const response = await axios.get('/api/getuser-data');
        userName.value = response.data.fullName;
    } catch (error) {
        console.error('Error fetching user name:', error);
    }
};
</script>
