<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 transition-opacity duration-300" style="z-index: 9999;">
    <div class="relative top-20 mx-auto p-5 border shadow-2xl rounded-2xl bg-white transform transition-all duration-300 scale-95" id="deleteModalContent" style="max-width: 400px; width: 90%;">
        <!-- Modal Header -->
        <div class="flex items-center justify-center mb-4">
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-red-100">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="text-center">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Delete Confirmation</h3>
            <p style="color: #6b7280; margin-bottom: 1.5rem; font-size: 0.95rem;" id="deleteModalMessage">
                Are you sure you want to delete this item? This action cannot be undone.
            </p>
        </div>

        <!-- Modal Footer -->
        <div style="display: flex; gap: 0.75rem;">
            <button type="button" onclick="closeDeleteModal()" style="flex: 1; background-color: #e5e7eb; color: #374151; font-weight: 600; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; transition: all 0.2s;">
                Cancel
            </button>
            <button type="button" onclick="confirmDelete()" style="flex: 1; background: linear-gradient(to right, #ef4444, #dc2626); color: white; font-weight: 600; padding: 0.75rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3); transition: all 0.2s;">
                Delete
            </button>
        </div>
    </div>
</div>

<style>
    #deleteModal button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
    }

    #deleteModal .text-center h3 {
        font-family: 'Playfair Display', serif;
    }
</style>

<script>
    let deleteFormToSubmit = null;

    function openDeleteModal(form, message = 'Are you sure you want to delete this item? This action cannot be undone.') {
        deleteFormToSubmit = form;
        document.getElementById('deleteModalMessage').textContent = message;
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.backgroundColor = 'rgba(17, 24, 39, 0.75)';
            modalContent.style.transform = 'scale(1)';
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');

        modalContent.style.transform = 'scale(0.95)';
        modal.style.backgroundColor = 'rgba(17, 24, 39, 0.5)';

        setTimeout(() => {
            modal.classList.add('hidden');
            deleteFormToSubmit = null;
        }, 300);
    }

    function confirmDelete() {
        console.log('Delete modal confirmDelete called');
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
        closeDeleteModal();
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeDeleteModal();
                }
            });
        }
    });
</script>
