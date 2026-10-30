function toggleEdit(){
    const EditProfileSection = document.getElementById('editProfileSection');
    const overlay = document.getElementById('overlay');

    if(EditProfileSection.style.display === 'none' || EditProfileSection.style.display === ''){
        EditProfileSection.style.display = 'block';
        overlay.style.display = 'block'
    }else{
        EditProfileSection.style.display = 'none';
        overlay.style.display = 'none';
    }
}