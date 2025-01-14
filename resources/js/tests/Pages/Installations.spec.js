import { describe, it, expect, beforeEach, vi } from 'vitest';
import axios from 'axios';

const updateInstallation = async (editId, installationName, installationColor, installations, isEdit, errorMessage) => {
    try {
        const { data } = await axios.put(`/api/v1/installation/${editId.value}`, {
            id: editId.value,
            name: installationName.value,
            color: installationColor.value,
        });
        installations.value = installations.value.map(installation =>
            installation.id === editId.value ? data.data : installation
        );

        isEdit.value = false;
        editId.value = null;
        installationName.value = null;
        installationColor.value = '#ff0000';
    } catch (error) {
        errorMessage.value = error.message;
    }
};

vi.mock('axios');

describe('updateInstallation', () => {
    let editId;
    let installationName;
    let installationColor;
    let installations;
    let isEdit;
    let errorMessage;

    beforeEach(() => {
        editId = { value: 1 };
        installationName = { value: 'New Installation' };
        installationColor = { value: '#123456' };
        installations = {
            value: [
                { id: 1, name: 'Old Installation', color: '#000000' },
                { id: 2, name: 'Another Installation', color: '#ffffff' },
            ],
        };
        isEdit = { value: true };
        errorMessage = { value: null };
    });

    it('should update the installation and reset edit values on success', async () => {
        axios.put.mockResolvedValueOnce({
            data: {
                data: { id: 1, name: 'Updated Installation', color: '#654321' },
            },
        });

        await updateInstallation(editId, installationName, installationColor, installations, isEdit, errorMessage);

        expect(installations.value).toEqual([
            { id: 1, name: 'Updated Installation', color: '#654321' },
            { id: 2, name: 'Another Installation', color: '#ffffff' },
        ]);
        expect(isEdit.value).toBe(false);
        expect(editId.value).toBeNull();
        expect(installationName.value).toBeNull();
        expect(installationColor.value).toBe('#ff0000');
    });

    it('should set an error message on failure', async () => {
        axios.put.mockRejectedValueOnce(new Error('Network Error'));

        await updateInstallation(editId, installationName, installationColor, installations, isEdit, errorMessage);

        expect(errorMessage.value).toBe('Network Error');
    });
});
