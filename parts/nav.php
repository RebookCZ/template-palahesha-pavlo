<nav class="main-nav">
    <a href="index.html" class="logo">Training<em> Studio</em></a>
    <ul class="nav">
        <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
        <li class="scroll-to-section"><a href="#features">Q&A</a></li>
        <li class="scroll-to-section"><a href="#our-classes">Classes</a></li>
        <li class="scroll-to-section"><a href="#schedule">Schedules</a></li>
        <li class="scroll-to-section"><a href="#contact-us">Contact</a></li>
        <li class="main-button">
            <a onclick="openModal('signupModal')" id="openModalBtn">Sign Up</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="text-align: center; margin-top: 20px;">
                <span style="color: black; font-size: 14px;">
                    You logged in as <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> 
                    (<?php echo htmlspecialchars($_SESSION['role']); ?>)
                </span>
                <form action="users_db/logout.php" method="POST" style="margin-top: 5px;">
                    <button type="submit" class="btn btn-danger" style="font-size: 13px;">Log out</button>
                </form>
            </div>
        <?php endif; ?>
    </ul>
</nav>
