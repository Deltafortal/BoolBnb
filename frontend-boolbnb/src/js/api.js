import axios from 'axios';

const TOMTOM_API_KEY = import.meta.env.VITE_TT_API_KEY;

const apiClient = axios.create({
  baseURL: 'https://api.tomtom.com/search/2/geocode/',
});

apiClient.interceptors.request.use(config => {
  config.params = config.params || {};
  config.params.key = TOMTOM_API_KEY;
  return config;
});

export default apiClient;