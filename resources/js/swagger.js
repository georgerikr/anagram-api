import SwaggerUI from 'swagger-ui'
import 'swagger-ui/dist/swagger-ui.css';

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
SwaggerUI({
    dom_id: '#swagger-api',
    url: location.href.replace('/docs', '') + '/api.yaml',
    requestInterceptor: (request) => {
        request.headers['X-CSRF-TOKEN'] = csrfToken;
        return request;
      },
});